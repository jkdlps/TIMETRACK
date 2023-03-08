<?php
// connect database
$server = "localhost";
$user = "u947188626__TIMETRACK";
$pass = "*kN8xw+v$";
$db = "u947188626__TIMETRACK";

$conn = new mysqli($server, $user, $pass, $db);

if($conn->connect_error) {
    echo "Connection failed; " . $conn->connect_error;
} echo "Connection successful.";

// functions
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}