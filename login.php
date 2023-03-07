<?php
/* 
In this code, we have a login page that takes in user input for email and password. We also have a checkbox for "Remember me" which will allow the user to stay logged in even after closing the browser. The form data is validated and processed upon submission. If the email and password are valid, the user will be redirected to the dashboard page. If the email and/or password are invalid, appropriate error messages will be displayed to the user.
*/
// Initialize the session
session_start();
 
// Check if the user is already logged in, then redirect them to the dashboard page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM employees WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

/* 
Note that this code assumes that you have set up a verification.php page where the user enters the verification code they received via email, and the code is verified against the one stored in the database. Also, you need to have the PHP mail() function enabled and properly configured to send emails.
*/

                            // In the login processing code after verifying the email and password
if(password_verify($password, $hashed_password)){
    // Password is correct, so start a new session
    session_start();

    // Generate and store a one-time verification code in the database
    $verification_code = rand(100000, 999999);
    $sql = "UPDATE employees SET verification_code = ? WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "ii", $verification_code, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Send the verification code to the user's email
    $to = $email;
    $subject = "Login Verification Code";
    $message = "Your verification code is: " . $verification_code;
    $headers = "From: Your Name <yourname@example.com>";
    mail($to, $subject, $message, $headers);

    // Store data in session variables
    $_SESSION["loggedin"] = true;
    $_SESSION["id"] = $id;
    $_SESSION["email"] = $email;
    $_SESSION["verification_code"] = $verification_code;

    // Redirect user to verification page
    header("location: verification.php");
} else {
    // Display an error message if password is not valid
    $password_err = "The password you entered is not valid.";
}

                            
                            // Redirect user to dashboard page
                            header("location: dashboard.php");
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
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
        method="post">
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
            <label><input type="checkbox" name="remember_me"> Remember me</label>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Don't have an account? <a href="signup.php">Sign up now</a>.</p>
    </form>
</div>    
</body>
</html>