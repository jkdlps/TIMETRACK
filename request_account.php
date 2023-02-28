<?php
// Initialize the session
session_start();

// Include conn file
include "conn.php";
include "functions.php";

// Define variables and initialize with empty values
$employee_id = "";
$employee_id_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate employee id
    if(empty(sanitize($_POST["employee_id"]))){
        $employee_id_err = "Please enter your employee ID.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM employees WHERE id = ?";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_employee_id);

            // Set parameters
            $param_employee_id = sanitize($_POST["employee_id"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $employee_id = trim($_POST["employee_id"]);
                } else{
                    $employee_id_err = "This employee ID is not registered.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Check input errors before inserting into database
    if(empty($employee_id_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO account_requests (employee_id) VALUES (?)";

        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_employee_id);

            // Set parameters
            $param_employee_id = $employee_id;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}

include "header.php";
?>
    <div class="wrapper">
        <h2>Request Account</h2>
        <p>Please fill this form to request an account.</p>
        <form method="post">
            <div class="form-group <?php echo (!empty($employee_id_err)) ? 'has-error' : ''; ?>">
                <label>Employee ID</label>
                <input type="text" name="employee_id" class="form-control" value="<?php echo $employee_id; ?>">
                <span class="help-block"><?php echo $employee_id_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
    </div>
</body>
</html>
