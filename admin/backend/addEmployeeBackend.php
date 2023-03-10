<?php
session_start();
include "connection.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (name,email,password)
    VALUES ('$name','$email','$password')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Account Created Successfully";
        header("location: ../admin_dashboard.php");
    } else {
        $_SESSION['message'] = "Wrong Password";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>