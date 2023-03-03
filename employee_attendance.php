<?php
session_start();
include "conn.php";

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

    if (distance <= 100) { // check if user is within geofence center
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
}

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
// session_start();
// include "conn.php";
// // retrieve user ID from session
// $user_id = $_SESSION['user_id'];

// // retrieve current date and time in the user's timezone
// $user_timezone = new DateTimeZone('Asia/Manila');
// $current_time = new DateTime('now', $user_timezone);
// $current_date = $current_time->format('Y-m-d');

// // check connection
// if (!$conn) {
//   die("Connection failed: " . mysqli_connect_error());
// }

// // check if user has already timed in today
// $query = mysqli_prepare($conn, "SELECT * FROM attendance WHERE user_id = ? AND DATE(time_in) = ?");
// mysqli_stmt_bind_param($query, "is", $user_id, $current_date);
// mysqli_stmt_execute($query);
// $attendance_record = mysqli_fetch_assoc(mysqli_stmt_get_result($query));

// if ($attendance_record) {
//   // user has already timed in, display time in and button to time out
//   $time_in = new DateTime($attendance_record['time_in']);
//   $time_in->setTimezone($user_timezone);
//   $location = $attendance_record['location'];
//   $in_office = $attendance_record['in_office'];

//   echo "You timed in at " . $time_in->format('Y-m-d H:i:s') . " in " . $location . ".<br>";
//   if ($attendance_record['time_out'] == NULL) {
//     echo "<form action='time_out.php' method='post'><input type='submit' value='Time Out'></form>";
//   } else {
//     echo "You timed out at " . $attendance_record['time_out'] . ".<br>";
//   }
// } else {
//   // user has not timed in, display button to time in
//   echo "<form action='time_in.php' method='post'>";
//   echo "<input type='submit' value='Time In'>";
//   echo "</form>";
// }

// // close connection
// mysqli_close($conn);