<?php
include "../TIMETRACK/control/connection.php";

$id = $_GET['GETid'];

$sql = "SELECT * FROM admin WHERE id =$id";

$result=mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

$id=$row['id'];
$email= $row['email'];
$password=$row['password'];