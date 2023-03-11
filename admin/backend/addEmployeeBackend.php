<?php
session_start();
include "connection.php";

if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];

    $sql = "INSERT INTO users (firstname, lastname, email, password, role, designation)
            VALUES ('$firstname', '$lastname', '$email', '$password', '$role', '$designation')";

    if ($conn->query($sql) === TRUE) {
        alerter("success", "Successfully added employee");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        alerter("danger", "Error: $sql <br> $conn->error");
    }
}
$conn->close();
?>