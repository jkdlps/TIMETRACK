<?php
session_start();
include "connection.php";
include "../TIMETRACK/backend/message.php";


if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];

    if(!($password < 8)) {
        $sql = "INSERT INTO users (firstname, lastname, email, password, role, designation)
        VALUES ('$firstname', '$lastname', '$email', '$password', '$role', '$designation')";
    } else {
        $_SESSION['message'] = "Password must be at least 8 characters long.";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Add employee successful.";
        header("location: ../usersPage.php");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
        header("location: ../usersPage.php");
        exit();
    }
}
$conn->close();
?>
