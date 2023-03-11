<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login-form.php");
    exit();
}

// Check if it's a POST request
if (isset($_POST['submit'])) {    
    // Get the user's location from the POST data
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    
    // Check if the user is within the geofence (100 meters from the municipal office of Pulong Buhangin, Santa Maria, Bulacan)
    $geofence_latitude = 14.810880;
    $geofence_longitude = 120.983491;
    $distance = distance($latitude, $longitude, $geofence_latitude, $geofence_longitude);
    
    if ($distance <= 100) {        
        // User is within the geofence, record their attendance
        $sql = "INSERT INTO attendance (time_in, designation) VALUES ($timein, $designation)";
        
        // Get the user's email from the session
        $email = $_SESSION['email'];
        
        // Get the current time in the Asia/Manila timezone
        date_default_timezone_set('Asia/Manila');
        $time = date('Y-m-d H:i:s');
        
        // Insert the attendance record into the database with the time in
        $conn = mysqli_connect('localhost', 'username', 'password', 'database');
        $stmt = mysqli_prepare($conn, "INSERT INTO attendance (email, time_in, latitude, longitude, is_onsite) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssddd', $email, $time, $latitude, $longitude, $is_onsite);
        
        // Determine whether the employee is working onsite or remotely
        if ($distance <= 100) {
            $is_onsite = 1;
        } else {
            $is_onsite = 0;
        }
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        
        // Redirect the user to the employee panel
        header("Location: employee_panel.php");
        exit();
        
    } else {
        // User is outside the geofence, show an error message
        $error = "You are outside the geofence. Please go to the municipal office of Pulong Buhangin, Santa Maria, Bulacan to time in.";
    }
}

// Function to calculate the distance between two points (in kilometers)
function distance($lat1, $lon1, $lat2, $lon2) {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $km = $dist * 60 * 1.1515 * 1.609344;
    return $km * 1000;
}
?>