<?php
    $server = "localhost";
    $user = "u947188626_timetrack";
    $pass = "|5FnHl7#";
    $db = "u947188626_timetrack";
    
    $conn = new mysqli($server, $user, $pass, $db);
    
    if($conn->connect_error) {
        die("
        <div>
            <p style='color: red'>Connection failed: . $conn->connect_error</p>
        </div>");
    }
    echo "
    <div>
    <p style='color: gray'>Connection successful. (MySQLi)</p>
    </div>";

    // functions
    function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIMETRACK</title>

    <!-- water.css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <div>
        <h1>TIMETRACK: GPS Timekeeping System</h1>
        <p>Developed for Municipal Office of Barangay Pulong Buhangin, Santa Maria, Bulacan</p>
        <hr>
    </div>