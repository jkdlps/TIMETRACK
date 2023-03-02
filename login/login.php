<?php
    session_start();
    include "../header.php";

    if(isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM users WHERE email = $email";
        $query = $conn->query($sql);
        if($query->num_rows < 1) {
            $_SESSION['error'] = "Cannot find account with the given email.";
        } else {
            $row = $query->fetch_assoc();
            if(password_verify($password, $row['password'])) {
                $_SESSION['user'] = $row['id'];
            } else {
                $_SESSION['error'] = "Incorrect password.";
            }
        }
    } else {
        $_SESSION['error'] = "Input user credentials first";
    }
    header("Location: index.php");