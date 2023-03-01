<?php
include "header.php";
?>

<div>
    <p style="color: red">Warning: Work in progress! Cannot log in yet.</p>
</div>

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
include "conn.php";
session_start();

// redirect if logged in
if(isset($_SESSION['id'])) {
  if($_SESSION['role'] == 1) {
    header("Location: employer_dashboard.php");
  } elseif($_SESSION['role'] == 0) {
    header("Location: employee_dashboard.php");
  }
}

if(isset($_POST['submit'])) {
  echo "try if submitted";
}