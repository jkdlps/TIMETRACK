<?php
// Function to establish a database connection
function connect_db() {
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "database_name";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $conn;
}

// Function to insert a new employee record into the database
function insert_employee($name, $email, $password, $work_location) {
    $conn = connect_db();

    $sql = "INSERT INTO employees (name, email, password, work_location) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $password, $work_location);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_close($conn);
}

// Function to retrieve an employee record from the database by email
function get_employee_by_email($email) {
    $conn = connect_db();

    $sql = "SELECT * FROM employees WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $employee = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return $employee;
}

// Function to insert a new timesheet record into the database
function insert_timesheet($employee_id, $checkin_time, $checkout_time, $hours_worked, $approved_by_manager) {
    $conn = connect_db();

    $sql = "INSERT INTO timesheets (employee_id, checkin_time, checkout_time, hours_worked, approved_by_manager) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isssi", $employee_id, $checkin_time, $checkout_time, $hours_worked, $approved_by_manager);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_close($conn);
}

// Function to retrieve timesheet records from the database for a given week
function get_timesheets_by_week($employee_id, $week_start, $week_end) {
    $conn = connect_db();

    $sql = "SELECT * FROM timesheets WHERE employee_id = ? AND checkin_time >= ? AND checkout_time <= ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iss", $employee_id, $week_start, $week_end);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $timesheets = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    return $timesheets;
}

// Function to update the approved_by_manager field for a timesheet record
function update_timesheet_approval($timesheet_id, $approved) {
    $conn = connect_db();

    $sql = "UPDATE timesheets SET approved_by_manager = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $approved, $timesheet_id);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_close($conn);
}
?>
