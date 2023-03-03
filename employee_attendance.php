<?php
session_start();
include "conn.php";
?>
<script>
    function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
    var geofence_lat = 14.7981472; // latitude of geofence center
    var geofence_lon = 121.0450595; // longitude of geofence center
    var distance = getDistance(lat, lon, geofence_lat, geofence_lon);

    if (distance <= 500) { // check if user is within 500 meters from geofence center
        // user is in office
        var status = "Time In";
        var work_from_home = 0;
        recordAttendance(status, work_from_home);
    } else {
        // user is working from home
        var status = "Time In (Work from Home)";
        var work_from_home = 1;
        recordAttendance(status, work_from_home);
    }
}

function recordAttendance(status, work_from_home) {
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var timezone = "Asia/Manila";
    var datetime = date + " \n" + time;
    alert("Attendance recorded:\nStatus: " + status + "\nDate and Time: " + datetime + " \nTimezone: " + timezone);

    // TODO: save record to database
    <?php
// Get the form data
$date = $_POST['date'];
$time = $_POST['time'];
$location = $_POST['location'];
$in_office = $_POST['in_office'];
$user_id = $_SESSION['user_id'];

// Convert the time to Asia/Manila timezone
$datetime = new DateTime($date . ' ' . $time, new DateTimeZone('UTC'));
$datetime->setTimezone(new DateTimeZone('Asia/Manila'));
$timestamp = $datetime->format('Y-m-d H:i:s');

// Check if the user has already timed in
$sql = "SELECT * FROM attendance WHERE user_id='$user_id' AND time_out IS NULL";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // User has already timed in, update the time_out column
  $row = mysqli_fetch_assoc($result);
  $id = $row['id'];
  $sql = "UPDATE attendance SET time_out='$timestamp' WHERE id='$id'";
  mysqli_query($conn, $sql);
} else {
  // User has not timed in yet, insert a new record
  $sql = "INSERT INTO attendance (user_id, time_in, location, in_office) VALUES ('$user_id', '$timestamp', '$location', '$in_office')";
  mysqli_query($conn, $sql);
}

mysqli_close($conn);

// Redirect to the dashboard
if($_SESSION['role'] == 1) {
    header('location: employer_dashboard.php');
} elseif($_SESSION['role'] == 0) {
    header('location: employee_dashboard.php');
}
exit();
?>

function getDistance(lat1, lon1, lat2, lon2) {
    var R = 6371; // Radius of the earth in km
    var dLat = deg2rad(lat2-lat1);  // deg2rad below
    var dLon = deg2rad(lon2-lon1);
    var a =
        Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
        Math.sin(dLon/2) * Math.sin(dLon/2)
        ;
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = R * c; // Distance in km
    return d * 1000; // Distance in meters
}

function deg2rad(deg) {
    return deg * (Math.PI/180)
}
}
</script>