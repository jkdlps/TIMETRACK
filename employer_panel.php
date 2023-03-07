<?php
session_start();
$server = "localhost";
$user = "u947188626__TIMETRACK";
$pass = "*kN8xw+v$";
$db = "u947188626__TIMETRACK";

$conn = mysqli_connect($server, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// prepare statements
$present_stmt = $conn->prepare("SELECT COUNT(*) FROM employees WHERE status = 'present'");
$absent_stmt = $conn->prepare("SELECT COUNT(*) FROM employees WHERE status = 'absent'");
$total_stmt = $conn->prepare("SELECT COUNT(*) FROM employees");
$ontime_stmt = $conn->prepare("SELECT COUNT(*) FROM time_records WHERE status = 'ontime'");
$late_stmt = $conn->prepare("SELECT COUNT(*) FROM time_records WHERE status = 'late'");

// execute statements
$present_stmt->execute();
$present_result = $present_stmt->get_result();
$present_count = $present_result->fetch_assoc()['COUNT(*)'];

$absent_stmt->execute();
$absent_result = $absent_stmt->get_result();
$absent_count = $absent_result->fetch_assoc()['COUNT(*)'];

$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_count = $total_result->fetch_assoc()['COUNT(*)'];

$ontime_stmt->execute();
$ontime_result = $ontime_stmt->get_result();
$ontime_count = $ontime_result->fetch_assoc()['COUNT(*)'];

$late_stmt->execute();
$late_result = $late_stmt->get_result();
$late_count = $late_result->fetch_assoc()['COUNT(*)'];

// output panel
echo "<h2>Employer Panel</h2>";
echo "<table>";
echo "<tr><td>Present Employees:</td><td>$present_count</td></tr>";
echo "<tr><td>Absent Employees:</td><td>$absent_count</td></tr>";
echo "<tr><td>Total Employees:</td><td>$total_count</td></tr>";
echo "<tr><td>Employees On Time:</td><td>$ontime_count</td></tr>";
echo "<tr><td>Late Employees:</td><td>$late_count</td></tr>";
echo "</table>";

// output tabs
echo "<h2>Tabs</h2>";
echo "<ul>";
echo "<li><a href='#'>Employees</a></li>";
echo "<li><a href='#'>Daily Time Records</a></li>";
echo "<li><a href='#'>Leaves</a></li>";
echo "</ul>";

// close database connection
$conn->close();

?>
