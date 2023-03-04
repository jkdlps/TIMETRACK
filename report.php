<?php
// Initialize the session
session_start();

// Check if the user is logged in, and if not, redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$week_start = $week_end = "";
$week_start_err = $week_end_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate week start date
    if (empty(trim($_POST["week_start"]))) {
        $week_start_err = "Please enter a start date.";
    } else {
        $week_start = trim($_POST["week_start"]);
    }

    // Validate week end date
    if (empty(trim($_POST["week_end"]))) {
        $week_end_err = "Please enter an end date.";
    } else {
        $week_end = trim($_POST["week_end"]);
    }

    // Check input errors before proceeding
    if (empty($week_start_err) && empty($week_end_err)) {

        // Convert week start and end dates to MySQL format
        $week_start_mysql = date("Y-m-d", strtotime($week_start));
        $week_end_mysql = date("Y-m-d", strtotime($week_end));

        // Prepare a select statement to retrieve all timesheets for the specified week
        $sql = "SELECT employees.name, timesheets.work_location, timesheets.date, timesheets.checkin_time, timesheets.checkout_time, timesheets.hours_worked, timesheets.approved_by_manager FROM timesheets JOIN employees ON timesheets.employee_id = employees.id WHERE date BETWEEN ? AND ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $week_start_mysql, $week_end_mysql);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Store the result set
        $result = mysqli_stmt_get_result($stmt);

        // Close the statement
        mysqli_stmt_close($stmt);

        // Close the database connection
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report</title>
</head>
<body>
    <h2>Report</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label>Week Start:</label>
            <input type="date" name="week_start" value="<?php echo $week_start; ?>">
            <span><?php echo $week_start_err; ?></span>
        </div>
        <div>
            <label>Week End:</label>
            <input type="date" name="week_end" value="<?php echo $week_end; ?>">
            <span><?php echo $week_end_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Generate Report">
        </div>
    </form>
    <?php if (!empty($result)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Work Location</th>
                    <th>Date</th>
                    <th>Check-in Time</th>
                    <th>Check-out Time</th>
                    <th>Hours Worked</th>
                    <th>Approved by Manager</th>
                    </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['work_location']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['checkin_time']; ?></td>
                <td><?php echo $row['checkout_time']; ?></td>
                <td><?php echo $row['hours_worked']; ?></td>
                <td><?php echo $row['approved_by_manager'] ? 'Yes' : 'No'; ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>
</body>
</html>