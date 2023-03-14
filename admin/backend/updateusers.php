<?php
session_start();
include "connection.php";
include "../TIMETRACK/backend/message.php";

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];

    if(!($password < 8)) {
        $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', email='$email', password='$password', role='$role', designation='$designation' WHERE id='$id'";
    } else {
        $_SESSION['message'] = "Password must be at least 8 characters long.";
        echo "<script>
        alert('Password must be at least 8 characters long')</script>";
    }

    if ($conn->query($sql) === TRUE) {
        header('Location: ../usersPage.php');
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
        header('Location: ../usersPage.php');
        exit();
    }

    $conn->close();
}
?>