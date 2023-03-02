<?php
include "conn.php";
// Get the form data
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$name = $_POST['name'];

// Insert the user into the database
$sql = "INSERT INTO users (email, password, name) VALUES ('$email', '$password', '$name')";

if (mysqli_query($conn, $sql)) {
  echo "User created successfully";
  header('Location: login.php');
} else {
  echo "Error: " . mysqli_error($conn);
}
mysqli_close($conn);
session_unset();