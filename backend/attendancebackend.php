<?php
session_start();
include("connection.php");

if (isset($_POST['submit'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $time_in = $_POST['time_in'];
    $time_out = $_POST['time_out'];

    $sql = "INSERT INTO location (latitude, longitude, time_in, time_out) VALUES ('$latitude', '$longitude', '$time_in', '$time_out')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Reserved Successfully";
        header("location: ../control/store_attendance.php");
    } else {
        $_SESSION['message'] = "Wrong Password";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>