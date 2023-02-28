<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$latitude = $longitude = $timestamp = $status = "";
$latitude_err = $longitude_err = $timestamp_err = $status_err = "";

// Check if the user has already timed in today
$employee_id = $_SESSION["id"];
$current_date = date("Y-m-d");
$sql = "SELECT id FROM attendance WHERE employee_id = ? AND date = ? LIMIT 1";
if($stmt = $mysqli->prepare($sql)){
    $stmt->bind_param("is", $param_employee_id, $param_date);
    $param_employee_id = $employee_id;
    $param_date = $current_date;
    if($stmt->execute()){
        $stmt->store_result();
        if($stmt->num_rows == 1){
            $status = "timed_in";
        }
    }
    $stmt->close();
}

// Process form data when button is clicked
if(isset($_POST["attendance"])){
    // Validate latitude
    if(empty(trim($_POST["latitude"]))){
        $latitude_err = "Please enter latitude.";
    } else{
        $latitude = trim($_POST["latitude"]);
    }

    // Validate longitude
    if(empty(trim($_POST["longitude"]))){
        $longitude_err = "Please enter longitude.";
    } else{
        $longitude = trim($_POST["longitude"]);
    }

    // Get current timestamp in Asia/Manila timezone
    date_default_timezone_set('Asia/Manila');
    $timestamp = date("Y-m-d H:i:s");

    // Check if the user is within the geofence
    $geofence_latitude = 14.820825;
    $geofence_longitude = 121.075441;
    $distance = distance($latitude, $longitude, $geofence_latitude, $geofence_longitude);
    if($distance > 100){
        $status_err = "You are not within the geofence.";
    } else{
        // Check if the user has already timed in
        if($status == "timed_in"){
            // Update attendance record with time out
            $sql = "UPDATE attendance SET time_out = ? WHERE employee_id = ? AND date = ?";
            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("sis", $param_time_out, $param_employee_id, $param_date);
                $param_time_out = $timestamp;
                $param_employee_id = $employee_id;
                $param_date = $current_date;
                if($stmt->execute()){
                    header("location: employee_dashboard.php");
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        } else{
            // Insert new attendance record
            $sql = "INSERT INTO attendance (employee_id, date, time_in) VALUES (?, ?, ?)";
            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param("iss", $param_employee_id, $param_date, $param_time_in);
                $param_employee_id = $employee_id;
                $param_date = $current_date;
                $param_time_in = $timestamp;
                if($stmt->execute()){
                    header("location: employee_dashboard.php");
                } else
                {
                    echo "Oops! Something went wrong. Please try again later.";
                }
                $stmt->close();
            }
        }
    }
}

// Calculate distance between two coordinates in meters
function distance($lat1, $lon1, $lat2, $lon2) {
$earth_radius = 6371000; // in meters
$dLat = deg2rad($lat2 - $lat1);
$dLon = deg2rad($lon2 - $lon1);
$a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
$distance = $earth_radius * $c;
return $distance;
}

include "header.php";
?>

    <div class="wrapper">
        <h2>Employee Attendance</h2>
        <?php if(!empty($status_err)): ?>
            <div class="alert alert-danger"><?php echo $status_err; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($latitude_err)) ? 'has-error' : ''; ?>">
                <label>Latitude</label>
                <input type="text" name="latitude" class="form-control" value="<?php echo $latitude; ?>">
                <?php if(!empty($latitude_err)): ?>
                    <span class="help-block"><?php echo $latitude_err; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group <?php echo (!empty($longitude_err)) ? 'has-error' : ''; ?>">
                <label>Longitude</label>
                <input type="text" name="longitude" class="form-control" value="<?php echo $longitude; ?>">
                <?php if(!empty($longitude_err)): ?>
                    <span class="help-block"><?php echo $longitude_err; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="attendance" value="<?php echo ($status == 'timed_in') ? 'Time Out' : 'Time In'; ?>">
            </div>
        </form>
    </div>
</body>
</html>    