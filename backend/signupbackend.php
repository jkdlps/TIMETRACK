<?php
session_start();
include "../control/connection.php";

if (isset($_POST['submit'])) {
    $email = $_POST['floatingInput'];
    $password = $_POST['floatingPassword'];
    $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    mysqli_query($con, $query);
    mysqli_close($con);
    header("location: ../loginpage.php");
    exit();
}
?>