<?php
/*
The form contains an input field for the user to enter the verification code they received via email. If the code is empty, an error message is displayed, and if the code is not empty, it is validated against the code stored in the database. If the code is valid, the user's status is updated to "active," and the verification code is set to NULL. If the code is not valid, an error message is displayed. Once the user's status is updated, they are redirected to the dashboard page.
*/
// Initialize the session
session_start();
 
// Include config file
// require_once "config.php";
$server = "localhost";
$user = "u947188626__TIMETRACK";
$pass = "*kN8xw+v$";
$db = "u947188626__TIMETRACK";

$conn = mysqli_connect($server, $user, $pass, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 
// Define variables and initialize with empty values
$verification_code = "";
$verification_code_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if verification code is empty
    if(empty(trim($_POST["verification_code"]))){
        $verification_code_err = "Please enter verification code.";
    } else{
        $verification_code = trim($_POST["verification_code"]);
    }
    
    // Validate verification code
    if(empty($verification_code_err)){
        // Prepare a select statement
        $sql = "SELECT id FROM employees WHERE verification_code = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_verification_code);
            
            // Set parameters
            $param_verification_code = $verification_code;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if verification code is valid
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Update user status to active and clear verification code
                    $sql = "UPDATE employees SET status = 'active', verification_code = NULL WHERE verification_code = ?";
                    
                    if($stmt = mysqli_prepare($conn, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "s", $param_verification_code);
                        
                        // Set parameters
                        $param_verification_code = $verification_code;
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            // Redirect user to dashboard page
                            header("location: dashboard.php");
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }

                        // Close statement
                        mysqli_stmt_close($stmt);
                    }
                } else{
                    // Display an error message if verification code is not valid
                    $verification_code_err = "The verification code you entered is not valid.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verification</title>
    <conn rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Verification</h2>
        <p>Please enter the verification code you received via email to verify your account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($verification_code_err)) ? 'has-error' : ''; ?>">
                <label>Verification Code</label>
                <input type="text" name="verification_code" class="form-control" value="<?php echo $verification_code; ?>">
                <span class="help-block"><?php echo $verification_code_err; ?></span>
            </div>
            <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
        </div>
    </form>
</div>    
</body>
</html>