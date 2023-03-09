<?php
session_start();
include "../control/functions.php";
head("Home");
?>
    <div class="container-fluid text-center mt-5 p-3">
        <div>
            <h1 class="h1">Timetrack: GPS Timekeeping System</h1>
            <p>Developed for Onsite, Remote, and Hybrid Working Employees of Barangay Pulong Buhangin, Santa Maria, Bulacan</p>
        </div>
        <div class="m-3 p-3">
            <a href="login-form.php" class="btn btn-primary">Log In</a>
            <a href="signup-form.php" class="btn btn-primary">Sign Up</a>
        </div>
    </div>
</body>
</html>