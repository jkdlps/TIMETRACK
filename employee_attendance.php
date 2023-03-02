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

      // Connect to the database
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "mydb";

      $conn = mysqli_connect($servername, $username, $password, $dbname);

      // Check for errors
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }

      // Get the user's geolocation
      if (isset($_POST['geo_lat']) && isset($_POST['geo_lng'])) {
        $geo_lat = $_POST['geo_lat'];
        $geo_lng = $_POST['geo_lng'];

        // Check if the user is within the geofence
        $geofence_lat = 14.8450725;
        $geofence_lng = 121.1024915;
        $geofence_radius = 100; // in meters

        $distance = distance($geo_lat, $geo_lng, $geofence_lat, $geofence_lng);

        if ($distance <= $geofence_radius) {
          $status = 1; // In office
        } else {
          $status = 0; // Work from home
        }

        // Insert the attendance record into the database
        $user_id = $_SESSION['user_id'];
        $date = date('Y-m-d');
        $time = date('H:i:s', strtotime('+8 hours')); // Asia/Manila timezone
        $sql = "INSERT INTO attendance (user_id, date, time, status) VALUES ('$user_id', '$date', '$time', '$status')";
        if (mysqli_query($conn, $sql)) {
          echo "<p>Attendance recorded.</p>";
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
      }

      // Helper function to calculate distance between two points in meters
      function distance($lat1, $lng1, $lat2, $lng2) {
        $earth_radius = 6371000; // in meters
        $lat1_rad = deg2rad($lat1);
        $lng1_rad = deg2rad($lng1);
        $lat2_rad = deg2rad($lat2);
        $lng2_rad = deg2rad($lng2);
        $delta_lat = $lat2_rad - $lat1_rad;
        $delta_lng = $lng2_rad - $lng1_rad;
        $a = sin($delta_lat/2) * sin($delta_lat/2) + cos($lat1_rad) * cos($lat2_rad) * sin($delta_lng/2) * sin($delta_lng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $earth_radius * $c;
        return $distance;
      }

      // Check if the user already timed in
      $user_id = $_SESSION['user_id'];
      $date = date('Y-m-d');
      $sql = "SELECT * FROM attendance WHERE user_id='$user_id' AND date='$date'";
      $result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
// User already timed in, display "Time Out" button
echo "Time Out";
$row = mysqli_fetch_assoc($result);
$attendance_id = $row['id'];
$status = $row['status'];
if ($status == 2) {
// User worked from home
echo "<p>You worked from home today.</p>";
} else {
// User worked in the office
echo "<p>You worked in the office today.</p>";
}
} else {
// User has not timed in, display "Time In" button
echo "Time In";
}
?>
</button>
</form>

  </body>
</html>
<?php
  // Handle form submission
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Check if the user is within the geofence
    if (is_within_geofence($latitude, $longitude)) {
      $status = 1; // User worked in the office
    } else {
      $status = 2; // User worked from home
    }

    // Check if the user already timed in
    $sql = "SELECT * FROM attendance WHERE user_id='$user_id' AND date='$date'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      // User already timed in, update the record with the time out
      $row = mysqli_fetch_assoc($result);
      $attendance_id = $row['id'];
      $sql = "UPDATE attendance SET time_out='$time', status='$status' WHERE id='$attendance_id'";
      mysqli_query($conn, $sql);
      echo "You have successfully timed out.";
    } else {
      // User has not timed in, insert a new record with the time in
      $sql = "INSERT INTO attendance (user_id, date, time_in, status) VALUES ('$user_id', '$date', '$time', '$status')";
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