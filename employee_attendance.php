<?php
// Start session
session_start();
include "conn.php";

// Check if employee is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get employee details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$employee_name = $row['name'];

// Get current date and time
$timezone = "Asia/Manila";
$date_time = new DateTime("now", new DateTimeZone($timezone));
$date = $date_time->format('Y-m-d');
$time = $date_time->format('H:i:s');

// Check if employee has already timed in
$sql = "SELECT * FROM attendance WHERE user_id = '$user_id' AND time_in = '$time_in'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // Employee has already timed in, display time out button
    $row = mysqli_fetch_assoc($result);
    $attendance_id = $row['id'];
    $in_office = $row['in_office'];
    $status = "Time Out";
    $button_text = "Time Out";
} else {
    // Employee has not timed in yet, display time in button
    $attendance_id = "";
    $in_office = 0;
    $status = "Time In";
    $button_text = "Time In";
}

// Geolocation parameters
$geofence_lat = 14.7981472; // latitude of geofence center
$geofence_lon = 121.0450595; // longitude of geofence center
$geofence_radius = 100; // radius of geofence in meters

// Check if user is within geofence
if (isset($_GET['latitude']) && isset($_GET['longitude'])) {
    $latitude = $_GET['latitude'];
    $longitude = $_GET['longitude'];
    $distance = getDistance($latitude, $longitude, $geofence_lat, $geofence_lon);

    if ($distance <= $geofence_radius) {
        // User is in office
        $in_office = 1;
    } else {
        // User is working from home
        $in_office = 0;
    }
}

// Save attendance record
if (isset($_POST['submit'])) {
    $status = $_POST['status'];
    $in_office = $_POST['in_office'];
    if ($attendance_id == "") {
        // Insert new attendance record
        $sql = "INSERT INTO attendance (user_id, date, time, status, in_office) VALUES ('$user_id', '$date', '$time', '$status', '$in_office')";
    } else {
        // Update existing attendance record
        $sql = "UPDATE attendance SET time = '$time', status = '$status', in_office = '$in_office' WHERE id = '$attendance_id'";
    }
    mysqli_query($conn, $sql);
}

// Get distance between two points on the Earth's surface
function getDistance($lat1, $lon1, $lat2, $lon2) {
    $R = 6371; // Radius of the earth in km
    $dLat = deg2rad($lat2-$lat1);  // deg2rad below
    $dLon = deg2rad($lon2-$lon1);
    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $d = $R * $c; // Distance in km
    return $d;
}