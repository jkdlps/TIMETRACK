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

// Check if the user has already checked in
$sql = "SELECT id FROM time_logs WHERE employee_id = ? AND checkout_time IS NULL";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION["id"]);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    // User has already checked in, redirect to dashboard
    header("location: dashboard.php");
    exit;
}

// Get the current GPS location of the user
$gps_location = ""; // Replace this with code to retrieve the GPS location

// Record the check-in time in the database
$sql = "INSERT INTO time_logs (employee_id, checkin_time, gps_location) VALUES (?, NOW(), ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "is", $_SESSION["id"], $gps_location);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// Close the database connection
mysqli_close($conn);

// Redirect the user to the dashboard
header("location: dashboard.php");
exit;
?>
