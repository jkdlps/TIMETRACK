<?php
  session_start();
  echo "doge";
  include "header.php";
  echo "catto";

  // redirect if already logged in
  if(isset($_SESSION['id'])) {
    if($_SESSION['role'] == 1) {
      header("Location: employer_dashboard.php");
    } elseif($_SESSION['role'] == 0) {
      header("Location: employee_dashboard.php");
    }
  }
  echo "catto";
  
  // Handle form submission
  if (isset($_POST['submit'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $remember = isset($_POST['remember']) ? $_POST['remember'] : 0;
      echo "submitted";
  
      // Check if user is an employee or employer
      $query = "SELECT * FROM users WHERE email = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      echo "employee/r";
  
      if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          echo "if this shows";
          if (password_verify($password, $row['password'])) {
              // Password is correct, check if user has been validated with a one-time passcode
              if ($row['validated'] == 1) {
                echo "then this has the problem";
                  // User is validated, set session variables and redirect to dashboard
                  $_SESSION['id'] = $row['id'];
                  $_SESSION['role'] = $row['role'];
                  $_SESSION['name'] = $row['name'];
                  echo "catto";
                  var_dump($_SESSION); 
                  if ($remember == 1) {
                      setcookie("id", $row['id'], time() + (86400 * 30), "/");
                      setcookie("role", $row['role'], time() + (86400 * 30), "/");
                  }
                  if($row['role'] == 0) {
                    header("Location: employee_dashboard.php");
                    exit();
                  } elseif($row['role'] == 1) {
                    header("Location: employer_dashboard.php");
                    exit();
                  }
              } else {
                  // User needs to be validated with a one-time passcode
                  $_SESSION['temp_id'] = $row['id'];
                  $_SESSION['temp_role'] = $row['role'];
                  header("Location: validate.php");
                  exit();
              }
          }
      }  
      // If user is not found or password is incorrect, show error message
      $error_message = "Invalid email or password.";
  }
  
  // Handle forgot password request
  if (isset($_POST['forgot_password'])) {
      $email = $_POST['email'];
  
      // Check if email exists in database
      $query = "SELECT * FROM users WHERE email = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
  
      if ($result->num_rows == 1) {
          // Generate new password and update database
          $new_password = bin2hex(random_bytes(4));
          $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
          $query = "UPDATE users SET password = ? WHERE email = ?";
          $stmt = $conn->prepare($query);
          $stmt->bind_param("ss", $hashed_password, $email);
          $stmt->execute();
  
          // Send email with new password to user
          $to = $email;
          $subject = "New password for your account";
          $message = "Your new password is: " . $new_password;
          $headers = "From: timetrack@timetrack.shop";
          mail($to, $subject, $message, $headers);
  
          $success_message = "A new password has been sent to your email.";
      } else {
          $error_message = "Invalid email.";
      }
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