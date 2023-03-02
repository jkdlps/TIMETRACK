<?php
session_start();
include "header.php";
?>
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?></h1>
    <p>Your email is: <?php echo $_SESSION['user_email']; ?></p>
    <form method="post" action="update.php">
      <label>Name:</label>
      <input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>" required>
      <br>
      <label>Email:</label>
      <input type="email" name="email" value="<?php echo $_SESSION['user_email']; ?>" required>
      <br>
      <input type="submit" value="Update">
    </form>
  </body>
</html>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>