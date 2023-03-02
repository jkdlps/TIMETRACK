<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h3>Welcome, <?php echo $_SESSION['user_name']; ?></h3>
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
    <form action="view_employees.php" method="post">
        <button type="submit">View Employees</button>
    </form>
    <h3>Manage Daily Time Records</h3>
    <form action="view_dtr.php" method="post">
        <button type="submit">View Daily Time Records</button>
    </form>
    <form action="view_dtr_requests.php" method="post">
        <button type="submit">View Daily Time Record Change Requests</button>
    </form>
    <h3>Manage Leaves</h3>
    <form action="view_leaves.php" method="post">
        <button type="submit">View Employees on Leave</button>
    </form>
    <form action="view_leave_requests.php" method="post">
        <button type="submit">View Leave Requests</button>
    </form>
</div>