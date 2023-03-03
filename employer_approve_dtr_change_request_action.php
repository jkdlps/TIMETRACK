<?php
session_start();
include "conn.php";
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
  $request_id = $_POST['request_id'];
  $query = "UPDATE attendance_requests SET status = 'approved' WHERE id = ?";
  if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $request_id);
    if (mysqli_stmt_execute($stmt)) {
      echo "Attendance change request has been approved successfully.";
    } else {
      echo "Error occurred while approving the attendance change request.";
    }
    mysqli_stmt_close($stmt);
  }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reject'])) {
  $request_id = $_POST['request_id'];
  $query = "UPDATE attendance_requests SET status = 'rejected' WHERE id = ?";
  if ($stmt = mysqli_prepare($link, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $request_id);
    if (mysqli_stmt_execute($stmt)) {
      echo "Attendance change request has been rejected successfully.";
    } else {
      echo "Error occurred while rejecting the attendance change request.";
    }
    mysqli_stmt_close($stmt);
  }
}
mysqli_close($link);
?>
