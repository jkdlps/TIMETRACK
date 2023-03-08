<?php

function head($title) {
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> $title | Timetrack</title>
    
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>';
}

function db() {
    $con = mysqli_connect("localhost", "u947188626__TIMETRACK", "*kN8xw+v$", "u947188626__TIMETRACK");
    $conn = new mysqli("localhost", "u947188626__TIMETRACK", "*kN8xw+v$", "u947188626__TIMETRACK");
    return $con;
    return $conn;
}

function alerter($message, $type) {
    echo "<div class='alert alert-$type m-3'>
    <span>$message</span>
    </div>";
}

function redirect() {
    if(isset($_SESSION['user_id'])) {
        if($_SESSION['user_role'] == 1) {
            header("location: admin/dashboard.php");
            exit();
        } elseif($_SESSION['user_role'] == 0) {
            header("location: dashboard.php");
            exit();
        }
    }
}

?>