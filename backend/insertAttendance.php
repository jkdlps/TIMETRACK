<?php
session_start();
include "../control/functions.php";
db();

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];    

    $sql = "INSERT INTO attendance (latitude,longitude)
    VALUES ('$latitude','$longitude') WHERE id=$user_id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Reserved Successfully";
        header("location: ../loginpage.php");

    } else {
        $_SESSION['message'] = "Wrong Password";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    alerter("Error", "danger");
}
?>