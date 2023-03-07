<?php
/* This code displays an employee panel that shows the attendance status for today, the daily time records of the employee, and the list of leaves taken by the employee. The panel is created using HTML and PHP. The PHP code fetches data from the database using SQL queries and displays the data using HTML. The attendance status is determined by checking if the employee has clocked in for today. The daily time records are sorted by date in descending order. The leaves are sorted by start date in descending order.
*/
// Initialize the session
session_start();

// Include config file
require_once "config.php";

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Get user's ID
$id = $_SESSION["id"];

// Get today's date
$today = date("Y-m-d");

// Check if the user has clocked in for today
$attendance_status = "Absent";
$sql = "SELECT id FROM attendance WHERE employee_id = ? AND date = ? AND clock_in IS NOT NULL";
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "is", $id, $today);

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if user has clocked in
        if(mysqli_stmt_num_rows($stmt) > 0){
            $attendance_status = "Present";
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}

// Get user's daily time records
$sql = "SELECT date, clock_in, clock_out FROM attendance WHERE employee_id = ? ORDER BY date DESC";
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if there are any records
        if(mysqli_stmt_num_rows($stmt) > 0){
            // Bind the result to variables
            mysqli_stmt_bind_result($stmt, $date, $clock_in, $clock_out);

            // Create an array for the daily time records
            $daily_time_records = array();

            // Loop through the result and add each record to the array
            while(mysqli_stmt_fetch($stmt)){
                $daily_time_records[] = array("date"=>$date, "clock_in"=>$clock_in, "clock_out"=>$clock_out);
            }
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}

// Get user's leaves
$sql = "SELECT start_date, end_date, leave_type, status FROM leaves WHERE employee_id = ? ORDER BY start_date DESC";
if($stmt = mysqli_prepare($link, $sql)){
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Attempt to execute the prepared statement
    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if there are any records
        if(mysqli_stmt_num_rows($stmt) > 0){
            // Bind the result to variables
            mysqli_stmt_bind_result($stmt, $start_date, $end_date, $leave_type, $status);

            // Create an array for the leaves
            $leaves = array();

            // Loop through the result and add each leave to the array
            while(mysqli_stmt_fetch($stmt)){
                $leaves[] = array("start_date"=>$start_date, "end_date"=>$end_date, "leave_type"=>$leave_type, "status"=>$status);
            }
        }
    }
    // Close statement
    mysqli_stmt_close($stmt);
}
// Close the database connection
mysqli_close($link);
?>

<!-- HTML code for employee panel displaying attendance status for today and containing attendance tab, daily time records tab, leaves tab -->
<div class="container">
    <h1>Employee Panel</h1>
    <hr>
    <h2>Attendance</h2>
    <p>Today's Status: <?php echo $attendance_status; ?></p>
    <br>
    <h2>Daily Time Records</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Clock In</th>
                <th>Clock Out</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(isset($daily_time_records)){
                foreach($daily_time_records as $record){
                    echo "<tr>";
                    echo "<td>".$record['date']."</td>";
                    echo "<td>".$record['clock_in']."</td>";
                    echo "<td>".$record['clock_out']."</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <br>
    <h2>Leaves</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Leave Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(isset($leaves)){
                foreach($leaves as $leave){
                    echo "<tr>";
                    echo "<td>".$leave['start_date']."</td>";
                    echo "<td>".$leave['end_date']."</td>";
                    echo "<td>".$leave['leave_type']."</td>";
                    echo "<td>".$leave['status']."</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>