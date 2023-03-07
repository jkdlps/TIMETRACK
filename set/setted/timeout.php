<?php
// In this example, we first connect to the database using mysqli_connect(). We then prepare a statement for updating the daily time record table using mysqli_prepare(). The statement takes three parameters: time_out, user_id, and date.

// We then get the current date and time using PHP's date() function, and update the daily time record table by binding the current time, user_id, and date to the prepared statement using mysqli_stmt_bind_param() and executing the statement using mysqli_stmt_execute().

// Finally, we destroy the session using session_destroy() and display a simple "Time Out Page" message to the user in HTML.

// Start session
session_start();

// Connect to database
$server = "localhost";
$user = "u947188626__TIMETRACK";
$pass = "*kN8xw+v$";
$db = "u947188626__TIMETRACK";

$conn = mysqli_connect($server, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare statement for updating daily time record
$update_stmt = mysqli_prepare($conn, "UPDATE daily_time_record SET time_out=? WHERE user_id=? AND date=?");

// Get current date and time
$current_date = date('Y-m-d');
$current_time = date('H:i:s');

// Update time out in database
mysqli_stmt_bind_param($update_stmt, "sss", $current_time, $_SESSION['user_id'], $current_date);
mysqli_stmt_execute($update_stmt);

// Destroy session
session_destroy();
?>

<html>
<head>
    <title>Time Out Page</title>
</head>
<body>
    <h1>Time Out Page</h1>
    <p>Your time out has been recorded.</p>
</body>
</html>
