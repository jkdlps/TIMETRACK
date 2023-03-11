<?php
session_start();
include("connection.php");

if (isset($_POST['submit'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $time = date('H:i:s');
    $date = date('Y-m-d');

    $sql = "INSERT INTO timeout (latitude,longitude,timein,timeout,date )
    VALUES ('$latitude','$longitude',NULL,'$timeout','$date')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Timein Successfully";
        header("location: ../control/store_attendance.php");

    } else {
        $_SESSION['message'] = "Error!";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>