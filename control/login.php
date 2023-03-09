<?php
session_start();
include "functions.php";
db();


if (isset($_POST['submit'])) {
    alerter("logged in!", "success");
    $email = $_POST['email'];
    $password = $_POST['password'];

    $decoded = password_verify($password, PASSWORD_DEFAULT);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$decoded'";
    $result = mysqli_query($con, $query);
    alerter("successful database!", "success");
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['email'] = $email;
        header('Location: dashboard.php');
        exit();
    } else {
        echo 'Invalid email or password';
        header("location: ../loginpage.php");
        exit();
    }

    mysqli_close($con);
}
?>