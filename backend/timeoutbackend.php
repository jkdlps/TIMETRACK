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

    $sql = "SELECT * FROM attendances WHERE employee_id = '$employee_id' AND date='$datenow'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $_SESSION['attendance_id'] = $row['id'];
            $_SESSION['timeout'] = $row['timeout'];
        }
    }

    if($_SESSION['timeout'] == NULL) {
        $sql = "INSERT INTO location (timeout)
        VALUES ($timeout) WHERE employee_id = '$employee_id'";
    
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Time Out Successful";
            header("location: ../control/store_attendance.php");
    
        } else {
            $_SESSION['message'] = "Error!";
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        $message = "Already timed in.";
        $class = "alert-danger";
    }

    // $sql = "INSERT INTO location (timeout)
    // VALUES ($timeout) WHERE employee_id = '$employee_id'";

    // if ($conn->query($sql) === TRUE) {
    //     $_SESSION['message'] = "Time Out Successful";
    //     header("location: ../control/store_attendance.php");

    // } else {
    //     $_SESSION['message'] = "Error!";
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }

    
}
?>