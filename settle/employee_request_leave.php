<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Your Leave Requests</h2>
</div>

<div>
    <form action='employee_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>