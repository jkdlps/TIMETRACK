<?php
session_start();
include "../control/connection.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];    
    $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    mysqli_query($con, $query);
    mysqli_close($con);
    header("location: ../loginpage.php");
    exit();
}
?>