<?php
session_start();
include "../backend/connection.php";
// include "../backend/message.php";

if (isset($_POST['submit'])) {
    $employee_id = $_SESSION['id'];
    date_default_timezone_set('Asia/Manila');
    $datenow = date('Y-m-d');
    $timeout = date('H:i:s');
    $id = $_SESSION['attendance_id'];

    // $sql = "INSERT INTO location (timeout)
    // VALUES ('$timeout') WHERE employee_id='$employee_id'";

    $sql = "UPDATE attendances SET timeout = '$timeout' WHERE id='$id' AND employee_id = '$employee_id' AND date='$datenow'";

    echo $sql;

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Reserved Successfully";
        header("location: store_attendance.php");

    } else {
        $_SESSION['message'] = "Wrong Password";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}