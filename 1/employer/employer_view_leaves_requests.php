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

// Define variables and initialize with empty values
$employee_id = $reason = $status = "";
$employee_id_err = $reason_err = $status_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate employee ID
    if(empty(trim($_POST["employee_id"]))){
        $employee_id_err = "Please select an employee.";
    } else{
        $employee_id = trim($_POST["employee_id"]);
    }

    // Validate reason
    if(empty(trim($_POST["reason"]))){
        $reason_err = "Please enter a reason.";
    } else{
        $reason = trim($_POST["reason"]);
    }

    // Validate status
    if(empty(trim($_POST["status"]))){
        $status_err = "Please select a status.";
    } else{
        $status = trim($_POST["status"]);
    }

    // Check input errors before inserting in database
    if(empty($employee_id_err) && empty($reason_err) && empty($status_err)){
        // Prepare an update statement to approve/deny leave request
        $sql = "UPDATE leaves SET status = ?, comment = ? WHERE id = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssi", $param_status, $param_comment, $param_id);

            // Set the parameters
            $param_status = $status;
            $param_comment = $reason;
            $param_id = trim($_POST["leave_id"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Leave request updated successfully, refresh page
                header("location: " . $_SERVER["PHP_SELF"]);
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }
}

// Prepare a select statement to get employee leave requests
$sql = "SELECT l.id, l.employee_id, e.firstname, e.lastname, l.start_date, l.end_date, l.reason, l.status, l.comment FROM leaves l
        LEFT JOIN employees e ON l.employee_id = e.id
        WHERE l.status = 'Pending'";

if($result = $mysqli->query($sql)){
    // Check if there are any employee leave requests
    if($result->num_rows > 0){
        // Build table header
        $table = "<table class='table'>";
        $table .= "<thead>";
        $table .= "<tr>";
        $table .= "<th>Employee</th>";
        $table .= "<th>Start Date</th>";
        $table .= "<th>End Date</th>";
        $table .= "<th>Reason</th>";
        $table .= "<th>Status</th>";
        $table .= "<th>Actions</th>";
        $table .= "</tr>";
        $table .= "</thead>";
        $table .= "<tbody>";

        // Fetch employee leave requests
        while($row = $result->fetch_assoc()){
            // Build table row
            $table .= "<tr>";
            $table .= "<td>" . $row["firstname"] . " " . "</td>";
            $table .= "<td>" . $row["reason"] . "</td>";
            $table .= "<td>" . date('Y-m-d', strtotime($row["start_date"])) . "</td>";
            $table .= "<td>" . date('Y-m-d', strtotime($row["end_date"])) . "</td>";
            $table .= "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#modal-".$row["id"]."'>View Details</button></td>";
            $table .= "</tr>";


            
            // Build modal for leave request
            $modal = "<div id='modal-".$row["id"]."' class='modal fade' role='dialog'>";
            $modal .= "<div class='modal-dialog'>";
            $modal .= "<!-- Modal content-->";
            $modal .= "<div class='modal-content'>";
            $modal .= "<div class='modal-header'>";
            $modal .= "<h4 class='modal-title'>Leave Request Details</h4>";
            $modal .= "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
            $modal .= "</div>";
            $modal .= "<div class='modal-body'>";
            $modal .= "<p><strong>Employee Name:</strong> " . $row["firstname"] . " " . $row["lastname"] . "</p>";
            $modal .= "<p><strong>Reason for Leave:</strong> " . $row["reason"] . "</p>";
            $modal .= "<p><strong>Start Date:</strong> " . date('Y-m-d', strtotime($row["start_date"])) . "</p>";
            $modal .= "<p><strong>End Date:</strong> " . date('Y-m-d', strtotime($row["end_date"])) . "</p>";
            $modal .= "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
            $modal .= "<input type='hidden' name='leave_id' value='".$row["id"]."'>";
            $modal .= "<div class='form-group'>";
            $modal .= "<label for='comment'>Comment:</label>";
            $modal .= "<textarea class='form-control' rows='5' id='comment' name='comment'></textarea>";
            $modal .= "</div>";
            $modal .= "<div class='form-group'>";
            $modal .= "<button type='submit' name='approve' class='btn btn-success'>Approve</button>";
            $modal .= "<button type='submit' name='deny' class='btn btn-danger'>Deny</button>";
            $modal .= "</div>";
            $modal .= "</form>";
            $modal .= "</div>";
            $modal .= "<div class='modal-footer'>";
            $modal .= "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
            $modal .= "</div>";
            $modal .= "</div>";
            $modal .= "</div>";
            $modal .= "</div>";

            // Append modal to modals array
            array_push($modals, $modal);
        }
        // End table
        $table .= "</tbody>";
        $table .= "</table>";
    } else{
        // No employee leave requests found
        $table = "<p>No employee leave requests found.</p>";
    }
} else{
    echo "Oops! Something went wrong. Please try again later.";
}

// Close connection
$mysqli->close();

include "header.php";
?>

