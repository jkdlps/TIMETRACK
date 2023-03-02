<?php
session_start(); // start session

// check if user is already logged in
if(isset($_SESSION["user_id"])) {
  // redirect to dashboard based on account type
  if($_SESSION["role"] == 1) {
    header("Location: employer_dashboard.php");
  } else {
    header("Location: employee_dashboard.php");
  }
  exit;
}

// include database connection
include_once "header.php";

// define variables and set to empty values
$email = $password = "";
$email_err = $password_err = "";

// process form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // validate email
  if(empty(sanitize($_POST["email"]))) {
    $email_err = "Please enter your email.";
  } else {
    $email = sanitize($_POST["email"]);
  }
  
  // validate password
  if(empty(sanitize($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } else {
    $password = sanitize($_POST["password"]);
  }

  // if no errors, attempt login
  if(empty($email_err) && empty($password_err)) {
    $sql = "SELECT id, email, password, is_employer FROM employee WHERE email = ?";
    
    if($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_email);
      $param_email = $email;
      
      if($stmt->execute()) {
        $stmt->store_result();
        
        // check if email exists
        if($stmt->num_rows == 1) {
          $stmt->bind_result($id, $email, $hashed_password, $is_employer);
          if($stmt->fetch()) {
            // verify password
            if(password_verify($password, $hashed_password)) {
              // password is correct, start session
              session_start();
              $_SESSION["user_id"] = $id;
              $_SESSION["email"] = $email;
              $_SESSION["is_employer"] = $is_employer;
              
              // redirect to dashboard based on account type
              if($is_employer == 1) {
                header("Location: employer_dashboard.php");
              } else {
                header("Location: employee_dashboard.php");
              }
            } else {
              // password is incorrect
              $password_err = "The password you entered is not valid.";
            }
          }
        } else {
          // email not found
          $email_err = "No account found with that email.";
        }
      } else {
        // query failed
        echo "Oops! Something went wrong. Please try again later.";
      }
      
      $stmt->close();
    }
  }
  
  $conn->close();
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