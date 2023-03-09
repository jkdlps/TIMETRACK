<?php
session_start();
include "functions.php";
$password = $_POST['password'];
$hashed = password_hash($password, PASSWORD_DEFAULT);
alerter("Your hashed password is $hashed", "info");
?>