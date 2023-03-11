<?php
include "../TIMETRACK/control/connection.php";

$id = $_GET['GETid'];

$sql = "SELECT * FROM attendance WHERE id =$id";

$result=mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

$id=$row['id'];
$name=  $row['name'];
$email= $row['email'];
$events= $row['events'];
$date= $row['date'];
$time= $row['time'];
$contact= $row['contact'];
$message=$row['message'];