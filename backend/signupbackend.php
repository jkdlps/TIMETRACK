<?php

include("connection.php");

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "INSERT INTO users (name, email, password) VALUES ('$name','$email', '$password')";
    mysqli_query($con, $query);
    mysqli_close($con);
    header("location: ../loginpage.php");
    exit();
}
?>