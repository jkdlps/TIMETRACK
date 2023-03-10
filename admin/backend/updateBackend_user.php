<?php
session_start();
include "../TIMETRACK/control/connection.php";

if(isset($_POST['update']))
{
    $id=$_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];
  

    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', contact='$contact', address='$address',email='$email', password='$password' WHERE id='$id'";
  
  if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
    header("location: ../usersPage.php");
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }  
  $conn->close();
  
}
?>