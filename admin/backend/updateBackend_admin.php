<?php
session_start();
include("connection.php");

if(isset($_POST['update']))
{
    $id=$_POST['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
  

    $sql = "UPDATE admin SET email='$email', password='$password' WHERE id='$id'";
  
  if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
    header("location: ../administrators.php");
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }



  
  $conn->close();
  
}






?>