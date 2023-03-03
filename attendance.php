<?php
session_start();
include "conn.php";
// Get user ID
$user_id = $_SESSION['user_id'];

// Get current date and time in Asia/Manila timezone
date_default_timezone_set("Asia/Manila");
$current_date = date("Y-m-d");
$current_time = date("H:i:s");

// Check if user has already timed in for today
$check_attendance_query = "SELECT * FROM attendance WHERE user_id = '$user_id' AND DATE(created_at) = '$current_date'";
$check_attendance_result = mysqli_query($conn, $check_attendance_query);

if (mysqli_num_rows($check_attendance_result) > 0) {
    // User has already timed in, update the time out
    $row = mysqli_fetch_assoc($check_attendance_result);
    $attendance_id = $row['id'];
    $time_in = $row['time_in'];
    $in_office = $row['in_office'];

    // Check if user is in office or not
    if ($in_office == 1) {
        // Geofence coordinates for municipal office of Pulong Buhangin, Santa Maria, Bulacan
        $office_lat = 14.839079;
        $office_lon = 120.981346;
        
        // Get user's current location coordinates
        $user_lat = $_POST['lat'];
        $user_lon = $_POST['lon'];
        
        // Get distance between user's current location and office coordinates
        $distance = getDistance($user_lat, $user_lon, $office_lat, $office_lon);
        
        if ($distance <= 1) {
            // User is within geofence, update the time out and in_office
            $update_attendance_query = "UPDATE attendance SET time_out = '$current_time', in_office = 1, updated_at = NOW() WHERE id = '$attendance_id'";
            $update_attendance_result = mysqli_query($conn, $update_attendance_query);
            
            if ($update_attendance_result) {
                echo "Time out recorded successfully.";
            } else {
                echo "Error updating time out: " . mysqli_error($conn);
            }
        } else {
            // User is not within geofence, update the time out and in_office
            $update_attendance_query = "UPDATE attendance SET time_out = '$current_time', in_office = 0, updated_at = NOW() WHERE id = '$attendance_id'";
            $update_attendance_result = mysqli_query($conn, $update_attendance_query);
            
            if ($update_attendance_result) {
                echo "Time out recorded successfully. You are working from home.";
            } else {
                echo "Error updating time out: " . mysqli_error($conn);
            }
        }
    } else {
        // User is not in office, update the time out
        $update_attendance_query = "UPDATE attendance SET time_out = '$current_time', updated_at = NOW() WHERE id = '$attendance_id'";
        $update_attendance_result = mysqli_query($conn, $update_attendance_query);
        
        if ($update_attendance_result) {
            echo "Time out recorded successfully.";
        } else {
            echo "Error updating time out: " . mysqli_error($conn);
        }
    }
} else {
    // User has not timed in yet, insert a new attendance record
    // Geofence coordinates for municipal office of Pulong Buhangin, Santa Maria, Bulacan
    $office_lat = 14.839079;
    $office_lon = 120.981346;
    
    // Get user's current location coordinates
    $user_lat = $_POST['lat'];
    $user_lon = $_POST['lon'];
    
    // Get distance between user's current location and office coordinates
    $distance = getDistance($user_lat, $user_lon, $office_lat, $office_lon);
    
    if ($distance <= 1) {
        // User is within geofence, set in_office to 1
        $in_office = 1;
    } else {
        // User is not within geofence, set in_office to 0
        $in_office = 0;
    }
    
    // Insert new attendance record
    $insert_attendance_query = "INSERT INTO attendance (user_id, time_in, in_office, created_at, updated_at) VALUES ('$user_id', '$current_time', '$in_office', NOW(), NOW())";
    $insert_attendance_result = mysqli_query($conn, $insert_attendance_query);
    
    if ($insert_attendance_result) {
        echo "Time in recorded successfully.";
    } else {
        echo "Error inserting new attendance record: " . mysqli_error($conn);
    }
}