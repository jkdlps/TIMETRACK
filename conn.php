<?php
$server = "localhost";
$user = "u947188626_timetrack";
$pass = "|5FnHl7#";
$db = "u947188626_timetrack";

$conn = new mysqli($server, $user, $pass, $db);

if($conn->connect_error) {
    die("
    <div>
        <p style='color: gray'>Connection failed: . $conn->connect_error</p>
    </div>");
}
echo "
<div>
<p style='color: gray'>Connection successful. (MySQLi)</p>
</div>";

$server = "localhost";
$user = "u947188626_timetrack";
$pass = "|5FnHl7#";
$db = "u947188626_timetrack";

try {
    $conn = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<div>
    <p style='color: gray'>Connection successful. (PDO)</p>
    </div>";
} catch(PDOException $e) {
    echo "
    <div>
    <p style='color: gray'>Connection failed: " . $e->getMessage() . "(PDO)</p>
    </div>";
}