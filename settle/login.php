<?php
session_start();
include "conn.php";

// if(isset($_SESSION['user_id'])) {
//     $_SESSION['loggedin'] = true;
//     if($_SESSION['user_role'] == 1) {
//       header('location: employer_dashboard.php');
//     } elseif($_SESSION['user_role'] == 0) {
//       header('location: employee_dashboard.php');
//     }
//   }

// Get the form data
$email = sanitize($_POST['email']);
$password = sanitize($_POST['password']);

// Check if the user exists
$sql = "SELECT * FROM users WHERE email = '$email'";

$result = mysqli_query($conn, $sql);

$sql = "SELECT * FROM users WHERE email = ?";

if (mysqli_num_rows($result) > 0) {
  // Verify the password
  $row = mysqli_fetch_assoc($result);
  if (password_verify($password, $row['password'])) {
    // Set the session variables
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_email'] = $row['email'];
    $_SESSION['user_name'] = $row['name'];
    $_SESSION['user_role'] = $row['role'];
    // Redirect to the dashboard
    if($_SESSION['user_role'] == 1) {
        header('Location: employer_dashboard.php');
    } elseif($_SESSION['user_role'] == 0) {
        header('Location: employee_dashboard.php');
    }
  } else {
    echo "Invalid password";
    header('Location: login-form.php');
  }
} else {
  echo "User not found";
  header('Location: login-form.php');
}

mysqli_close($conn);