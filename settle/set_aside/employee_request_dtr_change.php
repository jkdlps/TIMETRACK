<?php
// check if user is logged in and has employee role
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 0) {
    header("Location: login.php");
    exit();
}

require_once("db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $time = $_POST['time'];
    $date = $_POST['date'];
    $month = $_POST['month'];
    $reason = $_POST['reason'];
    $employeeId = $_SESSION['user_id'];

    // insert request into database
    $stmt = $mysqli->prepare("INSERT INTO dtr_change_requests (employee_id, time, date, month, reason) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $employeeId, $time, $date, $month, $reason);
    $stmt->execute();
    $stmt->close();

    // redirect to employee dashboard
    header("Location: employee_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request DTR Change</title>
</head>
<body>
    <h1>Request DTR Change</h1>

    <form method="post">
        <label for="time">Time:</label>
        <input type="time" id="time" name="time" required>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="month">Month:</label>
        <select id="month" name="month" required>
            <option value="January">January</option>
            <option value="February">February</option>
            <option value="March">March</option>
            <option value="April">April</option>
            <option value="May">May</option>
            <option value="June">June</option>
            <option value="July">July</option>
            <option value="August">August</option>
            <option value="September">September</option>
            <option value="October">October</option>
            <option value="November">November</option>
            <option value="December">December</option>
        </select>

        <label for="reason">Reason:</label>
        <textarea id="reason" name="reason" required></textarea>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
