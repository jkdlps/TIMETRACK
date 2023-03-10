<?php
session_start();
include "../backend/connection.php";

if (isset($_POST['submit'])) {
    $timeout = date('H:i:s');

    $sql = "INSERT INTO location (timeout)
    VALUES ('$timeout')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Reserved Successfully";
        header("location: store_attendance.php");

    } else {
        $_SESSION['message'] = "Wrong Password";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}