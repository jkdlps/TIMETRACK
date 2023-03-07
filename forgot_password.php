<?php
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
$email = "";
$email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Validate email
    if(empty($email_err)){
        // Prepare a select statement
        $sql = "SELECT password FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if email exists
                if(mysqli_stmt_num_rows($stmt) == 1){     
                    // Bind the result to variables
                    mysqli_stmt_bind_result($stmt, $password);
                    mysqli_stmt_fetch($stmt);

                    // Send email with password
                    $to = $email;
                    $subject = "Your Password";
                    $message = "Your password is: " . $password;
                    $headers = "From: noreply@example.com\r\n";
                    $headers .= "Reply-To: noreply@example.com\r\n";
                    $headers .= "Content-type: text/plain\r\n";
                    mail($to, $subject, $message, $headers);

                    // Redirect user to login page
                    header("location: login.php");
                } else{
                    // Display an error message if email does not exist
                    $email_err = "The email you entered does not exist.";
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
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Forgot Password</h2>
        <p>Please enter your email to retrieve your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Remember your password? <a href="login.php">Login here</a>.</p>
</form>

</div>
</body>
</html>