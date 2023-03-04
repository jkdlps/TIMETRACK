<?php
// Start the session
session_start();

// Check if the user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Query the timesheet data for the current week for the logged-in employee
$employee_id = $_SESSION["id"];
$current_week_start = date('Y-m-d', strtotime('monday this week'));
$current_week_end = date('Y-m-d', strtotime('sunday this week'));
$sql = "SELECT * FROM timesheets WHERE employee_id = ? AND checkin_time >= ? AND checkout_time <= ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "iss", $employee_id, $current_week_start, $current_week_end);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timesheets</title>
</head>
<body>
    <h2>Timesheets</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Check-in time</th>
                <th>Check-out time</th>
                <th>Hours worked</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row["checkin_time"]; ?></td>
                <td><?php echo $row["checkout_time"]; ?></td>
                <td><?php echo $row["hours_worked"]; ?></td>
                <td><a href="edit_timesheet.php?id=<?php echo $row["id"]; ?>">Edit</a></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php mysqli_close($conn); ?>
