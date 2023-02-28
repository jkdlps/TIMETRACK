<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== "employer"){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Prepare a select statement to get employee attendance records for today
$sql = "SELECT e.id, e.firstname, e.lastname, a.time_in, a.time_out, a.reason FROM employees e
        LEFT JOIN attendance a ON e.id = a.employee_id AND a.date = ?
        WHERE e.role = 'employee'";
if($stmt = $mysqli->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("s", $param_date);

    // Set the parameter
    $param_date = date("Y-m-d");

    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Store result
        $stmt->store_result();

        // Check if there are any employee attendance records for today
        if($stmt->num_rows > 0){
            // Bind result variables
            $stmt->bind_result($employee_id, $firstname, $lastname, $time_in, $time_out, $reason);

            // Employee attendance records for today found, start building table
            $table = "<table class='table'>";
            $table .= "<thead>";
            $table .= "<tr>";
            $table .= "<th>Name</th>";
            $table .= "<th>Time In</th>";
            $table .= "<th>Time Out</th>";
            $table .= "<th>Reason for Leave</th>";
            $table .= "</tr>";
            $table .= "</thead>";
            $table .= "<tbody>";

            // Fetch employee attendance records
            while($stmt->fetch()){
                $table .= "<tr>";
                $table .= "<td>" . $firstname . " " . $lastname . "</td>";
                $table .= "<td>" . ($time_in ? date('Y-m-d H:i:s', strtotime($time_in)) : "") . "</td>";
                $table .= "<td>" . ($time_out ? date('Y-m-d H:i:s', strtotime($time_out)) : "") . "</td>";
                $table .= "<td>" . ($reason ? $reason : "") . "</td>";
                $table .= "</tr>";
            }

            // End table
            $table .= "</tbody>";
            $table .= "</table>";
        } else{
            // No employee attendance records for today
            $table = "<p>No employee attendance records for today.</p>";
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$mysqli->close();

include "header.php";
?>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["firstname"]) . " " . htmlspecialchars($_SESSION["
lastname"]); ?></b>. Welcome to your dashboard.</h1>
</div>
<div class="wrapper">
<h2>Employee Attendance for Today</h2>
<?php echo $table; ?>
</div>
<p>
<a href="reset_password.php" class="btn btn-warning">Reset Your Password</a>
<a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
</p>

</body>
</html>