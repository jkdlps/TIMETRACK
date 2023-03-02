<?php
session_start();
require_once 'header.php';

// Check if user is already logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if($_SESSION["role"] == 1) {
        header("location: employer_dashboard.php");
    } else {
        header("location: employee_dashboard.php");
    }
    exit;
}

$email = $password = "";
$email_err = $password_err = "";

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
        $sql = "SELECT id, employee_id, name, email, password, role FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            $param_email = $email;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $employee_id, $name, $email, $hashed_password, $role);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["employee_id"] = $employee_id;
                            $_SESSION["name"] = $name;
                            $_SESSION["email"] = $email;   
                            $_SESSION["role"] = $role;
                            
                            // Check if remember me is checked
                            if(!empty($_POST["remember"])) {
                                // Set cookie for email and hashed password
                                setcookie("email", $email, time()+(86400*30), "/");
                                setcookie("hashed_password", password_hash($password, PASSWORD_DEFAULT), time()+(86400*30), "/");
                            }
                            
                            // Redirect user to dashboard
                            if($role == 1) {
                                header("location: employer_dashboard.php");
                            } else {
                                header("location: employee_dashboard.php");
                            }
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            mysqli_stmt_close($stmt);
        }
    }
    
    mysqli_close($conn);
}
?>

<div>
  <h2>Login</h2>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="remember">Remember Me:</label>
    <input type="checkbox" id="remember" name="remember">

    <input type="submit" name="submit" value="Log In">
  </form>
</div>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>