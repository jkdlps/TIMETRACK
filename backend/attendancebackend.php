<?php
session_start();
include "connection.php";
include "message.php";

if (isset($_POST['submit'])) {
    $employee_id = $_SESSION['employee_id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $timein = date('H:i:s');
    $date = date('Y-m-d');

    // geofence
    $geofence_latitude = 14.810880;
    $geofence_longitude = 120.983491;
    $distance = distance($latitude, $longitude, $geofence_latitude, $geofence_longitude);
    // Function to calculate the distance between two points (in kilometers)
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $km = $dist * 60 * 1.1515 * 1.609344;
        return $km * 1000;
    }
    // Determine whether the employee is working onsite or remotely
    if ($distance <= 100) {
        $location = "onsite";
    } else {
        $location = "remote";
    }

    $sql = "INSERT INTO location (employee_id,latitude,longitude,location,date,timein,timeout)
    VALUES ('$employee_id','$latitude','$longitude','$location','$date','$timein',NULL)";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Timein Successfully";
        header("location: ../control/store_attendance.php");
    } else {
        $_SESSION['message'] = "Error!";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<?php
// session_start();
// include("connection.php");

// if (isset($_POST['submit'])) {
//     $id = $_SESSION['id'];
//     $latitude = $_POST['latitude'];
//     $longitude = $_POST['longitude'];
//     $date = date('Y-m-d');

//     // Check if user has already timed in today
//     $check_sql = "SELECT * FROM location WHERE id = '$id' LIMIT 1";
//     $check_result = $conn->query($check_sql);
//     if ($check_result->num_rows > 0) {
//         $row = $check_result->fetch_assoc();
//         if ($row['timeout'] == NULL) {
//             // User has already timed in but has not timed out yet
//             $_SESSION['message'] = "You have already timed in. Please timeout first.";
//             header("location: ../control/store_attendance.php");
//             exit;
//         } else {
//             // User has already timed in and timed out, so proceed with timeout
//             $timeout = date('H:i:s');
//             $sql = "INSERT INTO location (latitude,longitude,timein,timeout,date )
//             VALUES ('$latitude','$longitude',NULL,'$timeout','$date')";
//             $_SESSION['message'] = "Timeout Successfully";
//             header("location: ../control/store_attendance.php");
//             exit;
//         }
//     } else {
//         // User has not yet timed in, so proceed with timein
//         $timein = date('H:i:s');
//         $sql = "INSERT INTO location (latitude,longitude,timein,timeout,date )
//         VALUES ('$latitude','$longitude','$timein',NULL,'$date')";
//         $_SESSION['message'] = "Timein Successfully";
//         header("location: ../control/store_attendance.php");
//         exit;
//     }

//     if ($conn->query($sql) === FALSE) {
//         $_SESSION['message'] = "Error!";
//         echo "Error: " . $sql . "<br>" . $conn->error;
//         exit;
//     }
// }
?>