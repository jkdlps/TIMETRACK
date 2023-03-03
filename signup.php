<?php
session_start();
include "conn.php";

if(isset($_SESSION['user_id'])) {
  if($_SESSION['user_role'] == 1) {
    header('location: employer_dashboard.php');
  } elseif($_SESSION['user_role'] == 0) {
    header('location: employee_dashboard.php');
  }
}

// // Get the form data
// $email = $_POST['email'];
// $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
// $name = $_POST['name'];

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO users (email, password, name) VALUES (?, ?, ?)");

// Bind parameters to the placeholders
$stmt->bind_param("sss", $email, $password, $name);

// Get the form data
$email = sanitize($_POST['email']);
$password = password_hash(sanitize($_POST['password']), PASSWORD_DEFAULT);
$name = sanitize($_POST['name']);
$stmt->execute();

if ($conn->query($sql)) {
  echo "<script>alert('User created successfully');</script>";
header('Location: login.php');
} else {
  echo "<script>alert('Error: " . mysqli_error($conn) . " ');</script>";
}


// Close statement and connection
$stmt->close();
$conn->close();

// // Insert the user into the database
// $sql = "INSERT INTO users (email, password, name) VALUES ('$email', '$password', '$name')";

// if (mysqli_query($conn, $sql)) {
//   echo "User created successfully";
//   header('Location: login.php');
// } else {
//   echo "Error: " . mysqli_error($conn);
// }
// mysqli_close($conn);
// session_unset();