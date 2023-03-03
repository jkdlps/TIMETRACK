<?php
// Connect to database and initialize session
require_once 'db_connect.php';
session_start();

// Check if user is logged in as employer, else redirect to login page
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header('Location: login.php');
    exit();
}

// Query database to get the number of absent, late, on time, and currently on leave employees
$stmt = $conn->prepare('SELECT 
                        COUNT(CASE WHEN status = "absent" THEN 1 END) AS absent_count,
                        COUNT(CASE WHEN status = "late" THEN 1 END) AS late_count,
                        COUNT(CASE WHEN status = "on time" THEN 1 END) AS on_time_count,
                        COUNT(CASE WHEN status = "on leave" THEN 1 END) AS on_leave_count
                        FROM attendance
                        WHERE MONTH(date) = MONTH(CURRENT_DATE())');
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$absentCount = $row['absent_count'];
$lateCount = $row['late_count'];
$onTimeCount = $row['on_time_count'];
$onLeaveCount = $row['on_leave_count'];

// Query database to get the list of employees
$stmt = $conn->prepare('SELECT * FROM users WHERE role = 0');
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query database to get the list of account requests
$stmt = $conn->prepare('SELECT * FROM account_requests');
$stmt->execute();
$accountRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query database to get the list of daily time records
$stmt = $conn->prepare('SELECT * FROM attendance');
$stmt->execute();
$dailyTimeRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query database to get the list of daily time record change requests
$stmt = $conn->prepare('SELECT * FROM attendance_change_requests');
$stmt->execute();
$dtrChangeRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query database to get the list of employees on leave
$stmt = $conn->prepare('SELECT * FROM leaves WHERE status = "on leave"');
$stmt->execute();
$employeesOnLeave = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query database to get the list of leave requests
$stmt = $conn->prepare('SELECT * FROM leaves WHERE status = "pending"');
$stmt->execute();
$leaveRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close database connection
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employer Dashboard</title>
</head>
<body>
    <h1>Employer Dashboard</h1>

    <p>Absent Employees: <?php echo $absentCount; ?></p>
    <p>Late Employees: <?php echo $lateCount; ?></p>
    <p>On Time Employees: <?php echo $onTimeCount; ?></p>
    <p>Employees on Leave: <?php echo $onLeaveCount; ?></p>

    <button onclick="location.href='employees.php'">View Employees</button>
    <button onclick="location.href='account_requests.php'">View Account Requests</button>
    <button onclick="location.href='daily_time_records.php'">View Daily Time Records</button>
    <button onclick="location.href='dtr_change_requests.php'">View DTR Change Requests</button>
    <button onclick="location.href='employees_on_leave.php'">View Employees on Leave</button>
    <button onclick="location.href='leave_requests.php'">View Leave Requests</button>

</body>
</html>