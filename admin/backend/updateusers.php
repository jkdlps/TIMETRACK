<?php
session_start();
include "../TIMETRACK/backend/connection.php";

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];

    $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', email='$email', role='$role', designation='$designation' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header('Location: usersTable.php');
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>