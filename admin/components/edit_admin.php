<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$id = $_GET['GETid'];

$sql = "SELECT * FROM admin WHERE id =$id";

$result=mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

$id=$row['id'];
$email= $row['email'];
$password=$row['password'];