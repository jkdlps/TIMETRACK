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

// Check if the user has already checked out
$sql = "SELECT id, checkin_time FROM time_logs WHERE employee_id = ? AND checkout_time IS NULL";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $time_log_id, $checkin_time);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if (empty($time_log_id)) {
    // User hasn't checked in, redirect to dashboard
    header("location: dashboard.php");
    exit;
}

// Get the current GPS location of the user
$gps_location = ""; // Replace this with code to retrieve the GPS location

// Calculate the number of hours worked
$checkin_time_obj = new DateTime($checkin_time);
$current_time_obj = new DateTime();
$hours_worked = $current_time_obj->diff($checkin_time_obj)->h;

// Record the check-out time and hours worked in the database
$sql = "UPDATE time_logs SET checkout_time = NOW(), gps_location = ?, hours_worked = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sii", $gps_location, $hours_worked, $time_log_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($conn);

// Redirect the user to the dashboard
header("location: dashboard.php");
exit;
?>
