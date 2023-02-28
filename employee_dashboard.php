<?php
session_start();
include "conn.php";
include "functions.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$employee_id = $_SESSION["id"];

// Fetch the attendance data of the employee for the current day
$current_date = date("Y-m-d");
$stmt = $mysqli->prepare("SELECT id, time_in, time_out FROM attendance WHERE employee_id = ? AND date = ?");
$stmt->bind_param("is", $employee_id, $current_date);
$stmt->execute();
$stmt->bind_result($attendance_id, $time_in, $time_out);
$stmt->fetch();
$stmt->close();

// Handle attendance button click
if(isset($_POST["attendance"])){
    if($attendance_id == 0){
        // Employee is taking attendance for the day
        $time_in = date("Y-m-d H:i:s");
        $latitude = 14.820188;
        $longitude = 121.064301;
        $stmt = $mysqli->prepare("INSERT INTO attendance (employee_id, date, time_in, latitude, longitude) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issdd", $employee_id, $current_date, $time_in, $latitude, $longitude);
        $stmt->execute();
        $attendance_id = $stmt->insert_id;
        $stmt->close();
    }
    else{
        // Employee is timing out for the day
        $time_out = date("Y-m-d H:i:s");
        $stmt = $mysqli->prepare("UPDATE attendance SET time_out = ? WHERE id = ?");
        $stmt->bind_param("si", $time_out, $attendance_id);
        $stmt->execute();
        $stmt->close();
        $attendance_id = 0;
    }
}

// Fetch the remaining leave credits of the employee
$stmt = $mysqli->prepare("SELECT leave_credits FROM employees WHERE id = ?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$stmt->bind_result($leave_credits);
$stmt->fetch();
$stmt->close();

// Fetch the list of leaves taken by the employee
$stmt = $mysqli->prepare("SELECT date_start, date_end, leave_type FROM leaves WHERE employee_id = ? ORDER BY date_start DESC");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$leaves = array();
while($row = $result->fetch_assoc()){
    $leaves[] = $row;
}
$stmt->close();

include "header.php";
?>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
    <h2>Attendance</h2>
    <form method="post">
        <?php if($attendance_id == 0): ?>
            <input type="submit" name="attendance" value="Take Attendance">
        <?php else: ?>
            <p>Time In: <?php echo $time_in; ?></p>
            <p>Time Out: <?php echo $time_out; ?></p>
            <input type="submit" name="attendance" value="Time Out">
        <?php endif; ?>
    </form>

    <h2>Leaves</h2>
    <p>Remaining Leave Credits: <?php echo $leave_contents['remaining_leave_credits']; ?></p>
    <table>
    <thead>
    <tr>
    <th>Type</th>
    <th>Date Filed</th>
    <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php while($row = $leaves_result->fetch_assoc()): ?>
    <tr>
    <td><?php echo $row['type']; ?></td>
    <td><?php echo $row['date_filed']; ?></td>
    <td><?php echo $row['status']; ?></td>
    </tr>
    <?php endwhile; ?>
    </tbody>
    </table>

    </body>
    </html>