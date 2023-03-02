<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Daily Time Record Change Requests</h2>
</div>

<div>
    <form action="employer_dtr_requests_approval.php" method="post">
        <button type="submit">Approve Daily Time Record Request</button>
    </form>
</div>

<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>