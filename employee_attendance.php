<?php
include "conn.php";
include "header.php";
?>
    <h1>Employee Attendance</h1>
    <?php
      // Start the session
      session_start();

      // Check if the user is logged in
      if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
      }

      // Get the user's geolocation
      if (isset($_POST['geo_lat']) && isset($_POST['geo_lng'])) {
        $geo_lat = $_POST['geo_lat'];
        $geo_lng = $_POST['geo_lng'];

    // Check if the user is within the geofence
    if (is_within_geofence($latitude, $longitude)) {
      $in_office = 1; // User worked in the office
    } else {
      $in_office = 0; // User worked from home
    }

    // Check if the user already timed in
    $sql = "SELECT * FROM attendance WHERE user_id='$user_id' AND date='$date'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      // User already timed in, update the record with the time out
      $row = mysqli_fetch_assoc($result);
      $attendance_id = $row['id'];
      $sql = "UPDATE attendance SET time_out='$time', in_office='$in_office' WHERE id='$attendance_id'";
      mysqli_query($conn, $sql);
      echo "You have successfully timed out.";
    } else {
      // User has not timed in, insert a new record with the time in
      $sql = "INSERT INTO attendance (user_id, date, time_in, in_office) VALUES ('$user_id', '$date', '$time', '$in_office')";
      mysqli_query($conn, $sql);
      echo "You have successfully timed in.";
    }
  }

  // Function to check if the user is within the geofence
  function is_within_geofence($latitude, $longitude) {
    // Coordinates of the municipal office of Pulong Buhangin, Santa Maria, Bulacan
    $office_latitude = 14.802242;
    $office_longitude = 121.064458;

    // Radius of the geofence in meters
    $radius = 100;

    // Calculate the distance between the user's coordinates and the office's coordinates using the Haversine formula
    $d_latitude = deg2rad($latitude - $office_latitude);
    $d_longitude = deg2rad($longitude - $office_longitude);
    $a = sin($d_latitude / 2) * sin($d_latitude / 2) + cos(deg2rad($office_latitude)) * cos(deg2rad($latitude)) * sin($d_longitude / 2) * sin($d_longitude / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = 6371000 * $c;

    // Check if the distance is within the radius
    return $distance <= $radius;
  }
?>