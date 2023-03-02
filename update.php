<?php
// Start the session
session_start();

// Connect to the database
include "conn.php";
?>

<?php
// Get the form data
$id = $_SESSION['user_id'];
$name = $_POST['name'];
$email = $_POST['email'];

// Update the user's information
$sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
  // Update the session variables
  $_SESSION['user_name'] = $name;
  $_SESSION['user_email'] = $email;
  // Redirect to the dashboard
  header('Location: dashboard.php');
} else {
  echo "Error updating record: " . mysqli_error($conn);
  header('Location: update-form.php');
}

mysqli_close($conn);