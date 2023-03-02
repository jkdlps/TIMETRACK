<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Your Daily Time Records</h2>
</div>

<div>
    <form action="employer_print_dtr.php" method="post">
        <button type="submit">Print Daily Time Record</button>
    </form>
</div>

<div>
    <form action='employee_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>