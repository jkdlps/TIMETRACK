<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Employer Dashboard</h2>
    <h3>Welcome, <?php echo $_SESSION['user_name']; ?></h3>
    <form action="update-form.php" method="post">
        <button type="submit">Update Info</button>
    </form>
</div>

<div>

</div>

<div>
    <form action="employee_dashboard.php" method="post">
        <button type="submit">View Dashboard as Employee</button>
    </form>
</div>

<div>
    <form action="view_employees.php" method="post">
        <button type="submit">View Employees</button>
    </form>
    <form action="view_dtr.php" method="post">
        <button type="submit">View Daily Time Records</button>
    </form>
    <form action="view_dtr_requests.php" method="post">
        <button type="submit">View Daily Time Record Change Requests</button>
    </form>
    <form action="view_leaves.php" method="post">
        <button type="submit">View Employees on Leave</button>
    </form>
    <form action="view_leave_requests.php" method="post">
        <button type="submit">View Leave Requests</button>
    </form>
</div>

<div>
    <form action="logout.php" method="get">
        <button type="submit">Log Out</button>
    </form>
</div>