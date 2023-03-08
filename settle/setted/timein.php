<?php
/*
This is the HTML code for the page where the user can clock in or out. If the user is absent for the day, a form will be displayed asking for the user's current location so that the system can check if the user is within the geofence before recording the attendance. If the user is on duty, a form with a "Clock Out" button will be displayed. Lastly, a "Sign Out" button is also provided to allow the user to log out of their account.
*/
// Initialize the session
session_start();

// Include config file
require_once "config.php";

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Get user's ID
$id = $_SESSION["id"];

// Get today's date
$today = date("Y-m-d");

// Get user's timezone
$user_timezone = new DateTimeZone('Asia/Manila');

// Get user's location
$lat = "";
$lng = "";
if(isset($_POST["lat"]) && isset($_POST["lng"])){
    $lat = $_POST["lat"];
    $lng = $_POST["lng"];
}

// Check if the user is within the geofence
$is_within_geofence = false;
if(!empty($lat) && !empty($lng)){
    $municipal_office_lat = 14.805567;
    $municipal_office_lng = 120.982739;
    $distance = distance($municipal_office_lat, $municipal_office_lng, $lat, $lng, "K");
    if($distance < 0.1){ // within 100 meters
        $is_within_geofence = true;
    }
}

// Record attendance if user is onsite and within the geofence
if(isset($_POST["clock_in"])){
    if($is_within_geofence){
        $clock_in_time = new DateTime('now', $user_timezone);
        $clock_in = $clock_in_time->format('Y-m-d H:i:s');
        $sql = "INSERT INTO attendance (employee_id, date, clock_in) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "iss", $id, $today, $clock_in);
            if(mysqli_stmt_execute($stmt)){
                header("location: time-in.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "You must be within the geofence to clock in.";
    }
}

// Update attendance if user is onsite and within the geofence
if(isset($_POST["clock_out"])){
    if($is_within_geofence){
        $clock_out_time = new DateTime('now', $user_timezone);
        $clock_out = $clock_out_time->format('Y-m-d H:i:s');
        $sql = "UPDATE attendance SET clock_out = ? WHERE employee_id = ? AND date = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sis", $clock_out, $id, $today);
            if(mysqli_stmt_execute($stmt)){
                header("location: time-in.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        echo "You must be within the geofence to clock out.";
    }
}

// Get user's attendance status
$attendance_status = "Absent";
$sql = "SELECT id FROM attendance WHERE employee_id = ? AND date = ?";
if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "is", $id, $today);
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) > 0){
            mysqli_stmt_bind_result($stmt, $attendance_id);
            mysqli_stmt_fetch($stmt);
            $attendance_status = "Present";
            if(empty($attendance_id)){
            $attendance_status = "Absent";
            } else {
            // Check if the user has clocked out
            $sql = "SELECT clock_out FROM attendance WHERE id = ?";
            if($stmt2 = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt2, "i", $attendance_id);
            if(mysqli_stmt_execute($stmt2)){
            mysqli_stmt_store_result($stmt2);
            mysqli_stmt_bind_result($stmt2, $clock_out);
            mysqli_stmt_fetch($stmt2);
            if(empty($clock_out)){
            $attendance_status = "On Duty";
            } else {
            $attendance_status = "Done";
            }
            }
            mysqli_stmt_close($stmt2);
            }
            }
            }
            mysqli_stmt_close($stmt);
            }
            }
            
            // Calculate distance between two locations
            function distance($lat1, $lon1, $lat2, $lon2, $unit) {
            if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
            } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
            if ($unit == "K") {
                return ($miles * 1.609344);
              } else if ($unit == "N") {
                  return ($miles * 0.8684);
                } else {
                return $miles;
              }
            }
        }
        ?>
        
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Time In</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Time In</h2>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</p>
        <p>Your attendance status for today is: <b><?php echo $attendance_status; ?></b></p>
        <?php if($attendance_status == "Absent"): ?>
            <form method="post">
                <div class="form-group">
                    <label>Latitude</label>
                    <input type="text" name="lat" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Longitude</label>
                    <input type="text" name="lng" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="clock_in" class="btn btn-primary" value="Clock In">
                </div>
            </form>
        <?php elseif($attendance_status == "On Duty"): ?>
            <form method="post">
                <div class="form-group">
                    <input type="submit" name="clock_out" class="btn btn-primary" value="Clock Out">
                </div>
            </form>
        <?php endif; ?>
        <p><a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a></p>
    </div>
</body>
</html>
