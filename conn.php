<?php
$server = "timetrack.shop";
$user = "u947188626_timetrack";
$pass = "|5FnHl7#";
$db = "u947188626_timetrack";

$conn = new mysqli($server, $user, $pass, $db);

if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}