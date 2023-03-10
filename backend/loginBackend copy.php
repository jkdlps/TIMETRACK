<?php
session_start();
include("connection.php");

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$email = $_POST['email'];
$password = $_POST['password'];
$errors = array();


  // Validate input
    if (empty($email) && empty($password)) {
    $errors['name'] = 'Empty fields is Required';
    echo '<span style="color:#DC0000;text-align:center;">Email and Password is required</span>';
    }

    else if (empty($email) ) 
    {
    $errors['email'] = 'Email Address is Required';

    echo '<span style="color:#DC0000;text-align:center;">Email is Required</span>';

    }
    else if (empty($password) ) 
    {
    $errors['password'] = 'Password is Required';
    echo '<span style="color:#DC0000;text-align:center;">Password is required</span>';
    }

    else {
      ob_start();
    // Escape input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Query database for user
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if user exists
    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
          $_SESSION['id'] = $row['id'];
          $_SESSION['role'] = $row['role'];
          $_SESSION["login"] = true;
          if($_SESSION['role'] == "admin") {
            header("location: ./admin/home.php");
            $_SESSION['message'] = "Login successful";
          } else {
            header("location: ./control/store_attendance.php");
            $_SESSION['message'] = "Welcome, Employee. Take your attendance here.";
          }
      }
  }
    else {
      echo '<span style="color:#DC0000;text-align:center;">Invalid email or password.</span>';
    }

    mysqli_close($conn); // Close database connection
}
}

?>