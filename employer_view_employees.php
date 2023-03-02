<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Employees</h2>
    <form action="employer_add_employee.php" method="post">
        <button type="submit">Add Employee</button>
    </form>
    <h2>Manage Admins</h2>
    <form action="employer_add_admin.php" method="post">
        <button type="submit">Add Admin</button>
    </form>
    <form action="employer_remove_admin.php" method="post">
        <button type="submit">Remove Admin</button>
    </form>
</div>

<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>