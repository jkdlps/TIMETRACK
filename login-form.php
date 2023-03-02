<?php
include "header.php";
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

