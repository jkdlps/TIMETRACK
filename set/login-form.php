<?php
session_start();
include "header.php";

if(isset($_SESSION['user_id'])) {
  if($_SESSION['user_role'] == 1) {
    header('location: employer_dashboard.php');
  } elseif($_SESSION['user_role'] == 0) {
    header('location: employee_dashboard.php');
  }
}
?>
    <h2>Login</h2>
    <form method="post" action="login.php">
      <label>Email:</label>
      <input type="email" name="email" required>
      <br>
      <label>Password:</label>
      <input type="password" name="password" required>
      <br>
      <input type="submit" value="Login">
    </form>
  </body>
</html>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>

