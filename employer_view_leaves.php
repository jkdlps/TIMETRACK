<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Employees On Leave</h2>
</div>

<div>
    <form action="employer_leave_request_approval.php" method="post">
        <button type="submit">Approve Leave Request</button>
    </form>
</div>

<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>