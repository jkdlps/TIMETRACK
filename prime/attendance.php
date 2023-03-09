<!DOCTYPE html>
<html>
<head>
    <title>Time In</title>
</head>
<body>
    <h1>Time In</h1>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post">
        <label for="latitude">Latitude:</label>
        <input type="text" id="latitude" name="latitude" required><br>
        <label for="longitude">Longitude:</label>
        <input type="text" id="longitude" name="longitude" required><br>
        <button type="button" onclick="getLocation()">Share location</button>
        <input type="submit" value="Time In">
    </form>
    
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
        }
    </script>
</body>
</html>

<?php

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get the user's location from the POST data
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    
    // Check if the user is within the geofence (100 meters from the municipal office of Pulong Buhangin, Santa Maria, Bulacan)
    $geofence_latitude = 14.810880;
    $geofence_longitude = 120.983491;
    $distance = distance($latitude, $longitude, $geofence_latitude, $geofence_longitude);
    
    if ($distance <= 100) {
        
        // User is within the geofence, record their attendance
        
        // Get the user's email from the session
        $email = $_SESSION['email'];
        
        // Get the current time in the Asia/Manila timezone
        date_default_timezone_set('Asia/Manila');
        $time = date('Y-m-d H:i:s');
        
        // Insert the attendance record into the database
        include "conn.php";
        $stmt = mysqli_prepare($conn, "INSERT INTO attendance (email, time_in) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, 'ss', $email, $time);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        // Redirect the user to the employee panel
        header("Location: employee_panel.php");
        exit();
        
    } else {
        
        // User is outside the geofence, store their attendance as "remote"
        
        // Get the user's email from the session
        $email = $_SESSION['email'];
        
        // Get the current time in the Asia/Manila timezone
        date_default_timezone_set('Asia/Manila');
        $time = date('Y-m-d H:i:s');
        
        // Insert the attendance record into the database with the status "remote"
$conn = mysqli_connect('localhost', 'username', 'password', 'database');
$stmt = mysqli_prepare($conn, "INSERT INTO attendance (email, time_in, status) VALUES (?, ?, ?)");
$status = "remote";
mysqli_stmt_bind_param($stmt, 'sss', $email, $time, $status);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);
    // Set an error message to be displayed on the form
    $error = "You are not within the geofence. Your attendance has been recorded as remote.";
}
}

// Function to calculate distance between two points on earth using the Haversine formula
function distance($lat1, $lon1, $lat2, $lon2) {
$radius = 6371; // Earth's radius in kilometers
$delta_lat = deg2rad($lat2 - $lat1);
$delta_lon = deg2rad($lon2 - $lon1);
$a = sin($delta_lat / 2) * sin($delta_lat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($delta_lon / 2) * sin($delta_lon / 2);
$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
$distance = $radius * $c;
return $distance * 1000; // Return distance in meters
}
?>