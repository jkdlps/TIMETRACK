<!DOCTYPE html>
<html>
<head>
    <title>Time Out</title>
</head>
<body>
    <h1>Time Out</h1>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form method="post">
        <label for="latitude">Latitude:</label>
        <input type="text" id="latitude" name="latitude" required><br>
        <label for="longitude">Longitude:</label>
        <input type="text" id="longitude" name="longitude" required><br>
        <button type="button" onclick="getLocation()">Share location</button>
        <input type="submit" value="Time Out">
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
        
        // Update the attendance record in the database with the time out
        $conn = mysqli_connect('localhost', 'username', 'password', 'database');
        $stmt = mysqli_prepare($conn, "UPDATE attendance SET time_out = ? WHERE email = ? AND DATE(time_in) = CURDATE()");
        mysqli_stmt_bind_param($stmt, 'ss', $time, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        // Redirect the user to the employee panel
        header("Location: employee_panel.php");
        exit();
        
    } else {
        
        // User is outside the geofence, show an error message
        $error = "You are outside the geofence. Please go to the municipal office of Pulong Buhangin, Santa Maria, Bulacan to time out.";
    }
}

// Function to calculate the distance between two points (in kilometers)
function distance($lat1, $lon1, $lat2, $lon2) {
    $radlat1 = pi() * $lat1 / 180;
    $radlat2 = pi() * $lat2 / 180;
    $theta = $lon1 - $lon2;
    $radtheta = pi() * $theta / 180;
    $distance = sin($radlat1) * sin($radlat2) + cos($radlat1) * cos($radlat2) * cos($radtheta);
    $distance = acos($distance);
    $distance = $distance * 180 / pi();
    $distance = $distance * 60 * 1.1515 * 1.609344;
    return $distance;
}

// Check if the user's attendance record for today has already been recorded
$email = $_SESSION['email'];
$conn = mysqli_connect('localhost', 'username', 'password', 'database');
$stmt = mysqli_prepare($conn, "SELECT time_in, time_out FROM attendance WHERE email = ? AND DATE(time_in) = CURDATE()");
mysqli_stmt_bind_param($stmt, 's', $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $time_in, $time_out);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Check if the user has already timed in today
if (empty($time_in)) {
    // User has not timed in yet, redirect to the time in page
    header("Location: time_in.php");
    exit();
} elseif (!empty($time_out)) {
    // User has already timed out today, show an error message
    $error = "You have already timed out for today.";
}
