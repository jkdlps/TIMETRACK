<?php
// Start the session
session_start();

// Check if the user is already logged in, if yes then redirect to employee dashboard
if (isset($_SESSION["employee_id"])) {
    header("location: employee_dashboard.php");
    exit;
}

// Include the database configuration file
require_once "conn.php";

// Define variables and initialize with empty values
$employee_id = $name = $email = $password = $confirm_password = "";
$employee_id_err = $name_err = $email_err = $password_err = $confirm_password_err = $otp = $otp_err = "";

include "functions.php";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate employee id
    if (empty(sanitize($_POST["employee_id"]))) {
        $employee_id_err = "Please enter your employee ID.";
    } else {
        $employee_id = sanitize($_POST["employee_id"]);
    }
    
    // Validate name
    if (empty(sanitize($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = sanitize($_POST["name"]);
    }
    
    // Validate email
    if (empty(sanitize($_POST["email"]))) {
        $email_err = "Please enter your email address.";
    } else {
        // Prepare a select statement
        $sql = "SELECT employee_id FROM employees WHERE email = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = sanitize($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    $email_err = "This email address is already taken.";
                } else {
                    $email = sanitize($_POST["email"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Validate password
    if (empty(sanitize($_POST["password"]))) {
        $password_err = "Please enter a password.";     
    } elseif (strlen(sanitize($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } else {
        $password = sanitize($_POST["password"]);
    }
    
    // Validate confirm password
    if (empty(sanitize($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = sanitize($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Validate OTP
    if (empty(sanitize($_POST["otp"]))) {
        $otp_err = "Please enter the one-time passcode sent to your email address.";     
    } else {
        // Prepare a select statement
        $sql = "SELECT otp FROM otp WHERE employee_id = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_employee_id);
            
            // Set parameters
            $param_employee_id = sanitize($_POST["employee_id"]);
            
            // Attempt to execute
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if OTP exists
                if ($stmt->num_rows == 1) {                    
                    // Bind result variables
                    $stmt->bind_result($hashed_otp);
                    if ($stmt->fetch()) {
                        if (password_verify(sanitize($_POST["otp"]), $hashed_otp)) {
                            // OTP is valid, start session and redirect to employee_dashboard.php
                            session_start();
                            $_SESSION["employee_id"] = $employee_id;
                            header("location: employee_dashboard.php");
                        } else {
                            $otp_err = "The one-time passcode you entered is invalid.";
                        }
                    }
                } else {
                    $otp_err = "The one-time passcode you entered is invalid.";
                }
            } else {
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
        <p>Please fill this form to request an account. Note that your account request will be subject for approval by your employer.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($employee_id_err)) ? 'has-error' : ''; ?>">
                <label>Employee ID</label>
                <input type="text" name="employee_id" class="form-control" value="<?php echo $employee_id; ?>">
                <span class="help-block"><?php echo $employee_id_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($otp_err)) ? 'has-error' : ''; ?>">
                <label>One-Time Passcode</label>
                <input type="text" name="otp" class="form-control" value="<?php echo $otp; ?>">
                <span class="help-block"><?php echo $otp_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
    
<div>
<form action="index.php" method="post">
    <input type="submit" value="Back to Homepage">
</form>
</div>

</body>
</html>