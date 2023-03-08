<?php
// Start session
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include database connection file
require_once "db_connection.php";

// Get the user's ID from the session variable
$user_id = $_SESSION['user_id'];

// Get the user's attendance records
$stmt = $conn->prepare("SELECT * FROM attendance WHERE user_id = ? ORDER BY date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Get the user's personal time records
$stmt2 = $conn->prepare("SELECT * FROM personal_time WHERE user_id = ? ORDER BY date DESC");
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$result2 = $stmt2->get_result();

// Get the user's leave requests
$stmt3 = $conn->prepare("SELECT * FROM leaves WHERE user_id = ? ORDER BY date DESC");
$stmt3->bind_param("i", $user_id);
$stmt3->execute();
$result3 = $stmt3->get_result();

// Check if the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user has submitted a leave request
    if(isset($_POST['submit_leave'])) {
        // Get the leave request details
        $leave_type = $_POST['leave_type'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $reason = $_POST['reason'];

        // Insert the leave request into the database
        $stmt4 = $conn->prepare("INSERT INTO leaves (user_id, leave_type, start_date, end_date, reason) VALUES (?, ?, ?, ?, ?)");
        $stmt4->bind_param("issss", $user_id, $leave_type, $start_date, $end_date, $reason);
        $stmt4->execute();
        $success_message = "Leave request submitted successfully.";
    }
}

// Close statements and database connection
$stmt->close();
$stmt2->close();
$stmt3->close();
$stmt4->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Panel - TIMETRACK</title>
</head>
<body>
    <h1>Employee Panel</h1>
    <h2>Attendance Records</h2>
<table>
    <tr>
        <th>Date</th>
        <th>Time In</th>
        <th>Time Out</th>
        <th>Passcode</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['date']; ?></td>
        <td><?php echo $row['time_in']; ?></td>
        <td><?php echo $row['time_out']; ?></td>
        <td><?php echo $row['passcode']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Personal Time Records</h2>
<table>
    <tr>
        <th>Date</th>
        <th>Hours</th>
        <th>Description</th>
    </tr>
    <?php while($row2 = $result2->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row2['date']; ?></td>
        <td><?php echo $row2['hours']; ?></td>
        <td><?php echo $row2['description']; ?></td>
    </tr>
    <?php endwhile;?>

</table>
<h2>Leave Requests</h2>
<?php if(isset($success_message)): ?>
<p><?php echo $success_message; ?></p>
<?php endif; ?>
<table>
    <tr>
        <th>Date</th>
        <th>Leave Type</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Reason</th>
        <th>Status</th>
    </tr>
    <?php while($row3 = $result3->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row3['date']; ?></td>
        <td><?php echo $row3['leave_type']; ?></td>
        <td><?php echo $row3['start_date']; ?></td>
        <td><?php echo $row3['end_date']; ?></td>
        <td><?php echo $row3['reason']; ?></td>
        <td><?php echo $row3['status']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<h2>Submit Leave Request</h2>
<form method="post">
    <label for="leave_type">Leave Type:</label>
    <select name="leave_type" required>
        <option value="">--Select Leave Type--</option>
        <option value="Vacation">Vacation</option>
        <option value="Sick Leave">Sick Leave</option>
        <option value="Personal Day">Personal Day</option>
    </select><br><br>
    <label for="start_date">Start Date:</label>
    <input type="date" name="start_date" required><br><br>
    <label for="end_date">End Date:</label>
    <input type="date" name="end_date" required><br><br>
    <label for="reason">Reason:</label>
    <textarea name="reason" required></textarea><br><br>
    <input type="submit" name="submit_leave" value="Submit Leave Request">
</form>
</body>
</html>