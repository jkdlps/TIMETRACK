<?php
    session_start();
    include "header.php";
?>

<div>
    <h3>Features:</h3>
    <ul>
        <li>Attendance Recording through Geolocation and Geofencing</li>
        <li>Printable Daily Time Record Generation & Change Request</li>
        <li>Leave Requesting & Management</li>
        <li>Employee & Employer Panels</li>
        <li>Employee Management</li>
        <li>Identification of Absent, Late, and On Time Employees</li>
        <li>One Time Passcode Verification through Email</li>
        <li>Password Change Request</li>
    </ul>
</div>

<div>
    <form action="login-form.php" method="get">
        <button type="submit">Log In</button>
    </form>
    <form action="signup-form.php" method="get">
        <button type="submit">Sign Up</button>
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
    <table>
    <h4>System Created by:</h4>
    <p>BSIT 4-1 2022-2023 Group 6</p>
        <tr>
            <th>Developers</th>
            <th>Roles</th>
        </tr>
        <tr>
            <td>Casimiro, Alvin</td>
            <td>Data Analyst</td>
        </tr>
        <tr>
            <td>Del Poso, James Kevin</td>
            <td>Programmer</td>
        </tr>
        <tr>
            <td>Dimanlig, Rafaelle</td>
            <td>Researcher</td>
        </tr>
        <tr>
            <td>Marqueta, Marq Joshua</td>
            <td>Project Manager</td>
        </tr>
    </table>
</div>

</body>
</html>