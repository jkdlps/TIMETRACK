<?php
include "header.php";
include "conn.php";
?>

<div>
  <form action="login.php" method="post">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="remember">Remember Me:</label>
    <input type="checkbox" id="remember" name="remember">

    <input type="submit" value="Log In">
  </form>
</div>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>

<?php
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $remember = isset($_POST['remember']);

  // Prepare a statement to retrieve user information
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  // Verify the password
  if ($user && password_verify($password, $user['password'])) {
    // Generate a remember token if the user checked "remember me"
    if ($remember) {
      $token = bin2hex(random_bytes(32));
      $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE id = ?");
      $stmt->execute([$token, $user['id']]);
      setcookie('remember_token', $token, time() + 3600 * 24 * 30, '/');
    }

    // Generate a one-time passcode and send it to the user's email
    $otp_token = bin2hex(random_bytes(4));
    $otp_expiry = date('Y-m-d H:i:s', time() + 300);
    $stmt = $pdo->prepare("UPDATE users SET otp_token = ?, otp_expiry = ? WHERE id = ?");
    $stmt->execute([$otp_token, $otp_expiry, $user['id']]);
    mail($user['email'], 'One-time passcode', "Your one-time passcode is $otp_token");

    // Redirect the user to the appropriate dashboard based on their role
    if ($user['role'] == 0) {
      header('Location: employee_dashboard.php');
    } elseif ($user['role'] == 1) {
      header('Location: employer_dashboard.php');
    }
    exit;
  } else {
    echo "Invalid email or password";
  }
}
?>
