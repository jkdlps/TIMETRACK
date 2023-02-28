<?php
// Initialize the session
session_start();

// Include conn file
require_once "conn.php";

// Define variables and initialize with empty values
$otp = "";
$otp_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate OTP
    if (empty(trim($_POST["otp"]))) {
        $otp_err = "<p style='color: red'>Please enter the one-time passcode sent to your email address.</p>";     
    } else {
        // Prepare a select statement
        $sql = "SELECT employee_id FROM otp WHERE otp = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_otp);
            
            // Set parameters
            $param_otp = trim($_POST["otp"]);
            
            // Attempt to execute
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();
                
                // Check if OTP is valid
                if ($stmt->num_rows == 1) {
                    // OTP is valid, store employee_id in session
                    $stmt->bind_result($employee_id);
                    if ($stmt->fetch()) {
                        $_SESSION["employee_id"] = $employee_id;
                        header("location: employee_dashboard.php");
                    }
                } else {
                    // OTP is not valid
                    $otp_err = "<p style='color: red'>The one-time passcode you entered is not valid.</p>";
                }
            } else {
                echo "<p style='color: red'>Oops! Something went wrong. Please try again later.</p>";
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
        <h2>Verify Email</h2>
        <p>Please enter the one-time passcode sent to your email address to verify your email.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($otp_err)) ? 'has-error' : ''; ?>">
                <label>One-Time Passcode</label>
                <input type="text" name="otp" class="form-control" value="<?php echo $otp; ?>">
                <span class="help-block"><?php echo $otp_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    

<div>
<form action="index.php" method="post">
    <input type="submit" value="Back to Homepage">
</form>
</div>

</body>
</html>
