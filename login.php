<form action="login.php" method="post">
  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required>

  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required>

  <label for="remember">Remember Me:</label>
  <input type="checkbox" id="remember" name="remember">

  <input type="submit" value="Log In">
</form>

<?php
// Connect to database
$db = new PDO('mysql:host=localhost;dbname=mydatabase', 'username', 'password');

// Prepare SQL statement
$stmt = $db->prepare('SELECT email, password, role FROM users WHERE email = :email');
$stmt->bindParam(':email', $_POST['email']);
$stmt->execute();

// Fetch user data
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check password
if ($user && password_verify($_POST['password'], $user['password'])) {
  // Password is correct, log user in
} else {
  // Password is incorrect, show error message
}


if ($user && password_verify($_POST['password'], $user['password'])) {
  // Password is correct, log user in
  $_SESSION['role'] = $user['role'];
  if ($_SESSION['role'] == 1) {
    // Employer, redirect to employer dashboard
    header('Location: employer_dashboard.php');
    exit();
  } else {
    // Employee, redirect to employee dashboard
    header('Location: employee_dashboard.php');
    exit();
  }
} else {
  // Password is incorrect, show error message
  echo 'Invalid email or password.';
}

if ($_POST['remember']) {
    // Remember user for 1 week
    setcookie('email', $_POST['email'], time() + 60*60*24*7);
    setcookie('password', $_POST['password'], time() + 60*60*24*7);
  }

  