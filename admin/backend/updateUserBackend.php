<?php
session_start();
include "../TIMETRACK/backend/message.php";
include "../TIMETRACK/control/connection.php";

if(isset($_POST['update']))
{
    $id=$_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];
  
    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', email='$email', password='$password',role='$role', designation='$designation' WHERE id='$id'";
  
  if (mysqli_query($conn, $sql)) {
    $_SESSION['message'] = "Employee updated successfully";
    alerter("success", "Employee updated successfully.");
    header("location: ../usersPage.php");
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }  
  $conn->close();
}
?>