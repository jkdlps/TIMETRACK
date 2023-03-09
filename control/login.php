<?php
session_start();
include "functions.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    db();

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['email'] = $email;
        header('Location: dashboard.php');
    } else {
        echo 'Invalid email or password';
    }

    mysqli_close($conn);
}
?>