<?php
// session_start();
// include("connection.php");

// if (isset($_POST['submit'])) {
//     $latitude = $_POST['latitude'];
//     $longitude = $_POST['longitude'];
//     $timein = date('H:i:s');
//     $date = date('Y-m-d');

//     $sql = "INSERT INTO location (latitude,longitude,timein,date )
//     VALUES ('$latitude','$longitude','$timein','$date')";

//     if ($conn->query($sql) === TRUE) {
//         $_SESSION['message'] = "Timein Successfully";
//         header("location: ../control/store_attendance.php");

//     } else {
//         $_SESSION['message'] = "Error!";
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }
?>

<?php
session_start();
include("connection.php");

if (isset($_POST['submit'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $date = date('Y-m-d');
    
    // Check if user has already timed in today
    $check_sql = "SELECT * FROM location WHERE date = '$date' LIMIT 1";
    $check_result = $conn->query($check_sql);
    if ($check_result->num_rows > 0) {
        $row = $check_result->fetch_assoc();
        if ($row['timeout'] == NULL) {
            // User has already timed in but has not timed out yet
            $_SESSION['message'] = "You have already timed in. Please timeout first.";
            header("location: ../control/store_attendance.php");
            exit;
        } else {
            // User has already timed in and timed out, so proceed with timeout
            $timeout = date('H:i:s');
            $sql = "INSERT INTO location (latitude,longitude,timein,timeout,date )
            VALUES ('$latitude','$longitude',NULL,'$timeout','$date')";
            $_SESSION['message'] = "Timeout Successfully";
            header("location: ../control/store_attendance.php");
            exit;
        }
    } else {
        // User has not yet timed in, so proceed with timein
        $timein = date('H:i:s');
        $sql = "INSERT INTO location (latitude,longitude,timein,timeout,date )
        VALUES ('$latitude','$longitude','$timein',NULL,'$date')";
        $_SESSION['message'] = "Timein Successfully";
        header("location: ../control/store_attendance.php");
        exit;
    }

    if ($conn->query($sql) === FALSE) {
        $_SESSION['message'] = "Error!";
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit;
    }
}
?>
