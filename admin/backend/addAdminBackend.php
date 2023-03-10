<?php
session_start();
include "connection.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 1;

    $sql = "INSERT INTO users (name,email,password,role)
    VALUES ('$name','$email','$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Account Created Successfully";
        header("location: ../administrators.php");
    } else {
        $_SESSION['message'] = "Wrong Password";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>