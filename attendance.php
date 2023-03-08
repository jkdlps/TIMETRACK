<?php
// Start session
session_start();

// Check if user is logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Include database connection file
require_once "db_connection.php";

// Check if the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get the user's ID from the session variable
    $user_id = $_SESSION['user_id'];

    // Check if the user has already clocked in
    $stmt = $conn->prepare("SELECT * FROM attendance WHERE user_id = ? AND date = CURDATE()");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the user has already clocked in, display an error message
    if($result->num_rows > 0) {
        $error_message = "You have already clocked in today.";
    } else {
        // Get the user's current location
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];

        // Check if the user is within the geofence
        // In this example, we're using a hardcoded geofence with a radius of 100 meters around a specific latitude and longitude
        $geofence_latitude = 14.8316;
        $geofence_longitude = 120.9649;
        $geofence_radius = 100;
        $distance = distance($latitude, $longitude, $geofence_latitude, $geofence_longitude);
        if($distance > $geofence_radius) {
            $error_message = "You must be within the geofence to clock in.";
        } else {
            // Generate a one-time passcode and send it to the user's registered email
            $passcode = generate_passcode();
            $to_email = get_user_email($user_id);
            $subject = "TIMETRACK Passcode Verification";
            $message = "Your one-time passcode for TIMETRACK is: " . $passcode;
            $headers = "From: admin@timetrack.com";

            if(mail($to_email, $subject, $message, $headers)) {
                // Insert the attendance record into the database
                $stmt = $conn->prepare("INSERT INTO attendance (user_id, date, time_in, passcode) VALUES (?, CURDATE(), NOW(), ?)");
                $stmt->bind_param("is", $user_id, $passcode);
                $stmt->execute();
                $success_message = "You have successfully clocked in.";
            } else {
                $error_message = "Error sending passcode email.";
            }
        }
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}

// Calculate the distance between two latitude and longitude coordinates
function distance($latitude1, $longitude1, $latitude2, $longitude2) {
    $earth_radius = 6371000; // meters
    $delta_latitude = deg2rad($latitude2 - $latitude1);
    $delta_longitude = deg2rad($longitude2 - $longitude1);
    $a = sin($delta_latitude/2) * sin($delta_latitude/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($delta_longitude/2) * sin($delta_longitude/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distance = $earth_radius * $c;
    return $distance;
    }
    
    // Generate a random 6-digit passcode
    function generate_passcode() {
    return rand(100000, 999999);
    }
    
    // Get the user's email address from the database
    function get_user_email($user_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['email'];
    }
    ?>