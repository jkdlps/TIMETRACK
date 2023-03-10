<?php
session_start();
include("connection.php");

if (isset($_POST['submit'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $time = date('H:i:s');
    $date = date('Y-m-d');

    $sql = "INSERT INTO attendance (latitude,longitude,time,date )
    VALUES ('$latitude','$longitude','$time','$date')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Reserved Successfully";
        header("location: ../loginpage.php");

    } else {
        $_SESSION['message'] = "Wrong Password";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>