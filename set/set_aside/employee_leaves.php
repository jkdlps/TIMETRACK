<?php
session_start();

// check if user is logged in as an employee
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'employee') {
    header('Location: login.php');
    exit();
}

// database connection
$conn = mysqli_connect('localhost', 'username', 'password', 'database');

// get employee's leave history
$employee_id = $_SESSION['user_id'];
$sql = "SELECT * FROM leaves WHERE employee_id = ? ORDER BY date_requested DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $employee_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// calculate remaining leave credit
$sql = "SELECT leave_credit FROM employees WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $employee_id);
mysqli_stmt_execute($stmt);
$result2 = mysqli_stmt_get_result($stmt);
$row2 = mysqli_fetch_assoc($result2);
$leave_credit = $row2['leave_credit'];
while ($row = mysqli_fetch_assoc($result)) {
    $leave_credit -= $row['days_requested'];
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Leaves</title>
</head>
<body>
    <h1>Employee Leave History</h1>

    <table>
        <tr>
            <th>Date Requested</th>
            <th>Leave Type</th>
            <th>Days Requested</th>
            <th>Status</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['date_requested']; ?></td>
            <td><?php echo $row['leave_type']; ?></td>
            <td><?php echo $row['days_requested']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
        <?php } ?>
    </table>

    <p>Remaining Leave Credit: <?php echo $leave_credit; ?> days</p>

    <form method="post" action="leave_request.php">
        <button type="submit">Request Leave Approval</button>
    </form>
</body>
</html>
