<?php
session_start();
require_once "conn.php";

// Redirect to login page if not logged in as employee
if(!isset($_SESSION["employee_id"]) || $_SESSION["is_employer"] != "0"){
    header("location: login.php");
    exit;
}

// Get employee's attendance records
$employee_id = $_SESSION["employee_id"];

// Filter by month if selected
if(isset($_GET["month"])){
    $month = $_GET["month"];
    $year = date("Y");
} else {
    $month = date("m");
    $year = date("Y");
}

// Prepare and execute MySQLi statement to get attendance records
$sql = "SELECT * FROM attendance WHERE employee_id = ? AND MONTH(time_in) = ? AND YEAR(time_in) = ? ORDER BY time_in DESC";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $employee_id, $month, $year);
$stmt->execute();
$result = $stmt->get_result();

// Prepare and execute MySQLi statement to get employee's name
$sql = "SELECT name FROM employees WHERE id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $employee_id);
$stmt->execute();
$name = $stmt->get_result()->fetch_assoc()["name"];

// Handle request for time record changes
if(isset($_POST["request_change"])){
    $attendance_id = $_POST["attendance_id"];
    $reason = $_POST["reason"];
    
    // Prepare and execute MySQLi statement to insert change request
    $sql = "INSERT INTO change_requests (attendance_id, reason) VALUES (?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $attendance_id, $reason);
    $stmt->execute();
    
    // Redirect to current page with success message
    header("location: employee_attendance.php?success=1");
    exit;
}

include "header.php";
?>
    <h1>Employee Attendance</h1>
    <h2><?php echo $name; ?></h2>
    <h3><?php echo date("F Y", strtotime($year."-".$month."-01")); ?></h3>
    
    <?php if(isset($_GET["success"]) && $_GET["success"] == 1): ?>
        <p style="color: green;">Change request submitted successfully.</p>
    <?php endif; ?>
    
    <form method="get">
        <label for="month">Filter by Month:</label>
        <select id="month" name="month">
            <?php for($i=1; $i<=12; $i++): ?>
                <option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT); ?>" <?php if($i == $month) echo "selected"; ?>><?php echo date("F", mktime(0, 0, 0, $i, 1)); ?></option>
            <?php endfor; ?>
        </select>
        <input type="submit" name="filter" value="Filter">
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Status</th>
                <th>Request Change</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc() ): ?>
<tr>
<td><?php echo date('M d, Y', strtotime($row['attendance_date'])); ?></td>
<td><?php echo date('h:i A', strtotime($row['time_in'])); ?></td>
<td><?php echo date('h:i A', strtotime($row['time_out'])); ?></td>
<td><?php echo $row['status']; ?></td>
<td><a href="request_change.php?id=<?php echo $row['id']; ?>">Request Change</a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</div>
</body>
</html>