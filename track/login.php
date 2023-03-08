<?php
session_start();
include "config.php";

if(isset($_SESSION['user_id'])) {
    if($_SESSION['user_role'] == 1) {
        header("location: admin/dashboard.php");
        exit();
    } elseif($_SESSION['user_role'] == 0) {
        header("location: dashboard.php");
        exit();
    }
}

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
}

?>