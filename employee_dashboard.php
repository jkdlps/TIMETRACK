<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Employee Dashboard</h2>
    <h3>Welcome, <?php echo $_SESSION['user_name']; ?></h3>
    <form action="update-form.php" method="post">
        <button type="submit">Update Info</button>
    </form>
</div>

<?php
    if($_SESSION['user_role'] == 1) {
        echo "
        <div>
            <form action='employer_dashboard.php' method='post'>
                <button type='submit'>View Dashboard as Employer</button>
            </form>
        </div>";
    }
?>

<div>
    <h3>Take Attendance:</h3>
    <?php include "employee_attendance.php"; ?>
    <button onclick="getLocation()">Time In</button>
</div>

<div>
    <form action="employee_attendance.php" method="post">
        <button type="submit">Take Your Attendance</button>
    </form>
    <form action="employee_view_dtr.php" method="post">
        <button type="submit">View Your Daily Time Records</button>
    </form>
    <form action="employee_request_dtr.php" method="post">
        <button type="submit">Request Daily Time Record Change</button>
    </form>
    <form action="employee_view_leaves.php" method="post">
        <button type="submit">View Your Leaves</button>
    </form>
    <form action="employee_request_leave.php" method="post">
        <button type="submit">Request Leave</button>
    </form>
</div>

<div>
    <form action="logout.php" method="get">
        <button type="submit">Log Out</button>
    </form>
</div>