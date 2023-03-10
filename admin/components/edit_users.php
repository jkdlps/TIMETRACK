<?php
include "../TIMETRACK/control/connection.php";

$id = $_GET['GETid'];

$sql = "SELECT * FROM users WHERE id =$id";

$result=mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

$id=$row['id'];
$firstname=  $row['firstname'];
$lastname= $row['lastname'];
$contact= $row['contact'];
$address= $row['address'];
$gender= $row['gender'];
$email= $row['email'];
$password=$row['password'];