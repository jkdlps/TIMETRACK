<?php 
include "conn.php"; 
include "functions.php";
?>
<?php
// Initialize the session
session_start();

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate email
    if(empty(sanitize($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        $email = sanitize($_POST["email"]);
    }
    
    // Validate password
    if(empty(sanitize($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = sanitize($_POST["password"]);
    }
    
    // Check input errors before processing further
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, firstname, lastname, email, password, role FROM employees WHERE email = ?";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if email exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $firstname, $lastname, $email, $password, $role);
                    if($stmt->fetch()){
                        // if(password_verify($password, $hashed_password)){
                            // Password is correct, start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["firstname"] = $firstname;
                            $_SESSION["lastname"] = $lastname;
                            $_SESSION["email"] = $email;
                            $_SESSION["role"] = $role;
                            
                            // Redirect user to OTP verification page
                            header("location: otp_verification.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered is not valid.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
            // Close connection
    $conn->close();
    }
        // // Close connection
        // $conn->close();

// }

include "header.php";
?>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please enter your email and password to log in.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>
</body>
</html>


<div>
    <form action="index.php" method="post">
        <input type="submit" value="Back to Homepage">
    </form>
</div>

<?php include "footer.php";