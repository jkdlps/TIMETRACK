<?php
// Start the session
session_start();

include "conn.php";

// Get the form data
$date = $_POST['date'];
$time = $_POST['time'];
$location = $_POST['location'];
$in_office = $_POST['in_office'];
$user_id = $_SESSION['user_id'];

// Convert the time to Asia/Manila timezone
$datetime = new DateTime($date . ' ' . $time, new DateTimeZone('UTC'));
$datetime->setTimezone(new DateTimeZone('Asia/Manila'));
$timestamp = $datetime->format('Y-m-d H:i:s');

// Check if the user has already timed in
$sql = "SELECT * FROM attendance WHERE user_id='$user_id' AND time_out IS NULL";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // User has already timed in, update the time_out column
  $row = mysqli_fetch_assoc($result);
  $id = $row['id'];
  $sql = "UPDATE attendance SET time_out='$timestamp' WHERE id='$id'";
  mysqli_query($conn, $sql);
} else {
  // User has not timed in yet, insert a new record
  $sql = "INSERT INTO attendance (user_id, time_in, location, in_office) VALUES ('$user_id', '$timestamp', '$location', '$in_office')";
  mysqli_query($conn, $sql);
}

mysqli_close($conn);

// Redirect to the dashboard
header("Location: dashboard.php");
exit();
?>
