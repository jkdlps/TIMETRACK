<?php
session_start();
include "functions.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];    
    db();
    if($_POST['password'] < 8) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }
    $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    mysqli_query($con, $query);
    mysqli_close($con);
    header("location: ../loginpage.php");
    exit();
}
?>