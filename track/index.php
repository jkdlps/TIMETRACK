<?php
session_start();
include "functions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Timetrack</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid text-center mt-5 p-3">
        <div>
            <h1 class="h1">Timetrack: GPS Timekeeping System</h1>
            <p>Developed for Onsite, Remote, and Hybrid Working Employees of Barangay Pulong Buhangin, Santa Maria, Bulacan</p>
        </div>
        <div class="m-3 p-3">
            <a href="login.php" class="btn btn-primary">Log In</a>
            <a href="signup.php" class="btn btn-primary">Sign Up</a>
        </div>
    </div>
</body>
</html>