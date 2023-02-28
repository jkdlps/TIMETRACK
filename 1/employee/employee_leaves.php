<?php
include "conn.php";
include "functions.php";
// Initialize the session
session_start();

// Check if the user is logged in as an employee
if(!isset($_SESSION["employee_id"]) || $_SESSION["role"] != "employee"){
    header("location: login.php");
    exit;
}

// Define variables and initialize with empty values
$reason = $start_date = $end_date = "";
$reason_err = $start_date_err = $end_date_err = "";

// Process form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate reason
    if(empty(sanitize($_POST["reason"]))){
        $reason_err = "Please enter the reason for your leave.";
    } else{
        $reason = sanitize($_POST["reason"]);
    }

    // Validate start date
    if(empty(sanitize($_POST["start_date"]))){
        $start_date_err = "Please enter the start date of your leave.";
    } else{
        $start_date = sanitize($_POST["start_date"]);
    }

    // Validate end date
    if(empty(sanitize($_POST["end_date"]))){
        $end_date_err = "Please enter the end date of your leave.";
    } else{
        $end_date = sanitize($_POST["end_date"]);
    }

    // Check input errors before inserting into database
    if(empty($reason_err) && empty($start_date_err) && empty($end_date_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO leaves (employee_id, reason, start_date, end_date) VALUES (?, ?, ?, ?)";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("isss", $param_employee_id, $param_reason, $param_start_date, $param_end_date);

            // Set parameters
            $param_employee_id = $_SESSION["employee_id"];
            $param_reason = $reason;
            $param_start_date = $start_date;
            $param_end_date = $end_date;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to dashboard page
                header("location: employee_dashboard.php");
                exit;
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}

include "header.php";
?>
    <div class="wrapper">
        <h2>Apply for Leave</h2>
        <p>Please fill in the following details to apply for leave.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($reason_err)) ? 'has-error' : ''; ?>">
                <label>Reason for Leave</label>
                <input type="text" name="reason" class="form-control" value="<?php echo $reason; ?>">
                <span class="help-block"><?php echo $reason_err; ?></span>
            </div
