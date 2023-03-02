<?php
    // connect to database
    $server = "localhost";
    $user = "u947188626_timetrack";
    $pass = "|5FnHl7#";
    $db = "u947188626_timetrack";
    
    $conn = mysqli_connect($server, $user, $pass, $db);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // functions
    function sanitize($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }