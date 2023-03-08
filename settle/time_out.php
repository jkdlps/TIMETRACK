<?php
session_start();
include "conn.php";
// retrieve user ID from session
$user_id = $_SESSION['user_id'];

// retrieve current date and time in the user's timezone
$user_timezone = new DateTimeZone('Asia/Manila');
$current_time = new DateTime('now', $user_timezone);
$current_datetime = $current_time->format('Y-m-d H:i:s');

// update attendance record with time out and set in_office status to 0
$update_query = "UPDATE attendance SET time_out = '$current_datetime', in_office = 0 WHERE user_id = '$user_id' AND DATE(time_in) = '$current_date' AND time_out IS NULL";

if (mysqli_query($conn, $update_query)) {
  echo "You timed out at " . $current_datetime . ".<br>";
} else {
  echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>