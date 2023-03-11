<?php
// session_start();
// include("connection.php");
// include "message.php";

// if (isset($_POST['submit'])) {
//     $employee_id = $_SESSION['employee_id'];
//     $latitude = $_POST['latitude'];
//     $longitude = $_POST['longitude'];
//     $time = date('H:i:s');
//     $date = date('Y-m-d');

//     $sql = "INSERT INTO timeout (employee_id,latitude,longitude,timein,timeout,date )
//     VALUES ('$employee_id','$latitude','$longitude',NULL,'$timeout','$date')";

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
include "message.php";

if (isset($_POST['submit'])) {
    $employee_id = $_SESSION['employee_id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $timeout = date('H:i:s');
    $date = date('Y-m-d');

    $sql = "INSERT INTO location (timeout)
    VALUES ($timeout) WHERE employee_id = '$employee_id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Time Out Successful";
        header("location: ../control/store_attendance.php");

    } else {
        $_SESSION['message'] = "Error!";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>