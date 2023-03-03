<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <p>Welcome, <?php echo $_SESSION['user_name']; ?></p>
    <h2>Employer Dashboard</h2>
</div>

<div>
    <h3>Manage Account</h3>
    <form action="update-form.php" method="post">
        <button type="submit">Update Info</button>
    </form>
    <form action="employee_dashboard.php" method="post">
        <button type="submit">View Dashboard as Employee</button>
    </form>
    <form action="logout.php" method="get">
        <button type="submit">Log Out</button>
    </form>
</div>

<div>
    <h3>Manage Employees</h3>
    <form action="employer_view_employees.php" method="post">
        <button type="submit">View Employees</button>
    </form>
    <!-- <form action="employer_view_lates.php" method="post">
        <button type="submit">View Late Employees</button>
    </form>
    <form action="employer_view_absences.php" method="post">
        <button type="submit">View Absent Employees</button>
    </form>
    <form action="employer_view_ontime.php" method="post">
        <button type="submit">View On Time Employees</button>
    </form> -->
    <form action="employer_view_admins.php" method="post">
        <button type="submit">View Admins</button>
    </form>

    <h3>Manage Daily Time Records</h3>
    <form action="employer_view_dtr.php" method="post">
        <button type="submit">View Daily Time Records</button>
    </form>
    <form action="employer_dtr_requests.php" method="post">
        <button type="submit">View Daily Time Record Change Requests</button>
    </form>

    <h3>Manage Leaves</h3>
    <form action="employer_view_leaves.php" method="post">
        <button type="submit">View Employees on Leave</button>
    </form>
    <form action="employer_view_leave_requests.php" method="post">
        <button type="submit">View Leave Requests</button>
    </form>
</div>