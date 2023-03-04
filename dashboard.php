<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include database config file
require_once "config.php";

// Retrieve the employee's information from the database
$sql = "SELECT name, work_location FROM employees WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $name, $work_location);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Initialize variables for check-in and check-out buttons
$button_text = "Check In";
$button_action = "checkin.php";

// Retrieve the latest time log for the employee
$sql = "SELECT id, checkin_time, checkout_time FROM time_logs WHERE employee_id = ? ORDER BY id DESC LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);
mysqli_stmt_bind_result($stmt, $time_log_id, $checkin_time, $checkout_time);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Determine if the employee is checked in or checked out
if ($checkout_time == null) {
    $button_text = "Check Out";
    $button_action = "checkout.php?id=" . $time_log_id;
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo $name; ?>!</h2>
    <p>Your work location is: <?php echo $work_location; ?></p>
    <form action="<?php echo $button_action; ?>" method="post">
        <input type="submit" value="<?php echo $button_text; ?>">
    </form>
</body>
</html>
