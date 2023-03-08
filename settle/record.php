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

    <?php 
    
// retrieve user ID from session
$user_id = $_SESSION['user_id'];

// retrieve current date and time in the user's timezone
$user_timezone = new DateTimeZone('Asia/Manila');
$current_time = new DateTime('now', $user_timezone);
$current_date = $current_time->format('Y-m-d');

// connect to database

// check if user has already timed in today
$query = "SELECT * FROM attendance WHERE user_id = '$user_id' AND DATE(time_in) = '$current_date'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  // user has already timed in, display time out button
  $attendance_record = mysqli_fetch_assoc($result);
  if ($attendance_record['time_out'] == NULL) {
    // time out button
    echo "<form action='attendance.php' method='post'><input type='hidden' name='action' value='time_out'><input type='submit' value='Time Out'></form>";
  } else {
    // already timed out
    echo "You timed out at " . $attendance_record['time_out'] . ".<br>";
  }
} else {
  // user has not timed in, display time in button
  echo "<form action='time_in.php' method='post'>";
  echo "<input type='submit' value='Time In'>";
  echo "</form>";
  // check if user is in the office or work from home
  $in_office = 0; // default to work from home
  $location = "Unknown";
  // use geolocation to determine if user is in the office
  // replace the following with your own geolocation code
  if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
    $lat = $_POST['latitude'];
    $lon = $_POST['longitude'];
    $geofence_lat = 14.7981472; // latitude of geofence center
    $geofence_lon = 121.0450595; // longitude of geofence center
    function getDistance(lat1, lon1, lat2, lon2) {
        $R = 6371; // Radius of the earth in km
        $dLat = deg2rad(lat2-lat1);  // deg2rad below
        $dLon = deg2rad(lon2-lon1);
        $a =
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon/2) * Math.sin(dLon/2)
            ;
        $c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        $d = R * c; // Distance in km
        return d * 1000; // Distance in meters
    }
    $distance = getDistance($lat, $lon, $geofence_lat, $geofence_lon);
    if ($distance <= 100) { 
      $in_office = 1;
      $location = "Municipal Office of Pulong Buhangin, Santa Maria, Bulacan";
    }
  }
  // time in button
  echo "<form action='attendance.php' method='post'><input type='hidden' name='action' value='time_in'><input type='hidden' name='location' value='$location'><input type='hidden' name='in_office' value='$in_office'><input type='submit' value='Time In'></form>";
}

mysqli_close($conn);

// handle time in or time out action
if (isset($_POST['action'])) {
  $action = $_POST['action'];
  $location = $_POST['location'];
  $in_office = $_POST['in_office'];
  $current_time = $current_time->format('Y-m-d H:i:s');

  if ($action == 'time_in') {
    // insert new attendance record with time in and location
    $query = "INSERT INTO attendance (user_id, time_in, location, in_office) VALUES ('$user_id', '$current_time', '$location', '$in_office')";
    mysqli_query($conn, $query);
  } elseif ($action == 'time_out') {
    // update attendance record
// get the latest attendance record for the user
$query = "SELECT * FROM attendance WHERE user_id = '$user_id' ORDER BY time_in DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  // update the latest attendance record with time out and out of office status
  $row = mysqli_fetch_assoc($result);
  $attendance_id = $row['id'];
  $query = "UPDATE attendance SET time_out = '$current_time', out_of_office = !'$in_office' WHERE id = '$attendance_id'";
  mysqli_query($conn, $query);
}
}

// redirect to dashboard
header('Location: employee_dashboard.php');
exit;
}
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