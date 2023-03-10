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