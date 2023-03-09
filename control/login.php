<?php
session_start();
// include "functions.php";
$con = mysqli_connect("localhost", "u947188626_timetrack", "|5FnHl7#", "u947188626_timetrack");

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $password = password_verify($_POST['password'], PASSWORD_DEFAULT);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['email'] = $email;
        header('Location: employee_dashboard.php');
    } else {
        echo 'Invalid email or password';
        header("location: ../loginpage.php");
    }

    mysqli_close($con);
}
?>