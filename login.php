<?php
include "header.php";
include "conn.php";
?>

<form action="login.php" method="post">
  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required>

  <label for="password">Password:</label>
  <input type="password" id="password" name="password" required>

  <label for="remember">Remember Me:</label>
  <input type="checkbox" id="remember" name="remember">

  <input type="submit" value="Log In">
</form>