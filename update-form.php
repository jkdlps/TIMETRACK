<?php
include "header.php";
?>

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