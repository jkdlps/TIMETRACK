<?php
session_start();
include("connection.php");

if(isset($_POST['update']))
{
    $id=$_POST['id'];
    $name= $_POST['name'];
    $email= $_POST['email'];
    $events= $_POST['events'];
    $date= $_POST['date'];
    $time= $_POST['time'];
    $contact= $_POST['contact'];
    $message=$_POST['message'];
  

    $sql = "UPDATE reservation SET name='$name', email='$email', events='$events', date='$date', time='$time', contact='$contact', message='$message' WHERE id='$id'";
  
  if (mysqli_query($conn, $sql)) {
    echo "Record updated successfully";
    header("location: ../reservationAdmin.php");
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }



  
  $conn->close();
  
}






?>