<?php
    session_start();
    include "header.php";
?>

<div>
    <h3>Features:</h3>
    <ul>
        <li>Geolocation & Geofencing Attendance</li>
        <li>Printable Daily Time Record Generation & Change Request</li>
        <li>Leave Requesting & Management</li>
        <li>Employee & Employer Panels</li>
        <li>Employee Management</li>
        <li>Absent, Late, and On Time Employees Reporting</li>
        <li>One Time Passcode Verification through Email</li>
        <li>Account Requesting</li>
        <li>Password Change Request</li>
    </ul>
</div>

<div>
    <form action="login.php" method="post">
        <button type="submit">Log In</button>
    </form>
    <hr>
</div>

<div>
    <h2>Documentation</h2>
    <div>
        <form action="desc_schema.php" method="get">
            <button type="submit">Read System Schema</button>
        </form>
    </div>
    <div>
        <form action="desc_structure.php" method="get">
            <button type="submit">Read System Structure</button>
        </form>
    </div>
</div>

<div>
    <h4>Created by BSIT 4-1 Group 6 consisting of:</h4>
    <ul>
        <li>Casimiro, Alvin as Data Analyst</li>
        <li>Del Poso, James Kevin as Programmer</li>
        <li>Dimanlig, Rafaelle as Researcher</li>
        <li>Marqueta, Marq Joshua as Project Manager</li>
    </ul>
</div>

</body>
</html>