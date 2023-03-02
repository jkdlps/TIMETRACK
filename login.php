<?php
session_start();
include "conn.php";
// Get the form data
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the user exists
$sql = "SELECT * FROM users WHERE email = '$email'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // Verify the password
  $row = mysqli_fetch_assoc($result);
  if (password_verify($password, $row['password'])) {
    // Set the session variables
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    // Redirect to the dashboard
    header('Location: dashboard.php');
  } else {
    echo "Invalid password";
  }
} else {
  echo "User not found";
}

mysqli_close($conn);