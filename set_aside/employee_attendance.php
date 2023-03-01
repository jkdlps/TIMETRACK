<?php
session_start(); // start session to access employee ID
require_once 'db_connect.php'; // include database connection file

// get current date and time in Asia/Manila timezone
$dateTime = new DateTime('now', new DateTimeZone('Asia/Manila'));
$currentDate = $dateTime->format('Y-m-d');
$currentTime = $dateTime->format('H:i:s');

// check if employee has already timed in for the day
$stmt = $conn->prepare("SELECT * FROM attendance WHERE employee_id = ? AND date = ?");
$stmt->bind_param("is", $_SESSION['employee_id'], $currentDate);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($result->num_rows == 0) {
  // employee has not yet timed in for the day, insert new attendance record
  $stmt = $conn->prepare("INSERT INTO attendance (employee_id, date, time_in) VALUES (?, ?, ?)");
  $stmt->bind_param("iss", $_SESSION['employee_id'], $currentDate, $currentTime);
  $stmt->execute();

  // display success message
  echo "<p>Attendance taken: Time In - " . $currentTime . "</p>";
} else {
  // employee has already timed in for the day, update existing attendance record with time out
  $stmt = $conn->prepare("UPDATE attendance SET time_out = ? WHERE id = ?");
  $stmt->bind_param("si", $currentTime, $row['id']);
  $stmt->execute();

  // display success message
  echo "<p>Attendance taken: Time Out - " . $currentTime . "</p>";
}

$stmt->close();
$conn->close();
?>
