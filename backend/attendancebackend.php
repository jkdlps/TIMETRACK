<?php
session_start();
include("connection.php");

if (isset($_POST['submit'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $sql = "INSERT INTO location (latitude,longitude,date,time) VALUES ('$latitude','$longitude', '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Reserved Successfully";
        header("location: ../usersindex.php");
    } else {
        $_SESSION['message'] = "Wrong Password";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>