<?php
  session_start();
  include "header.php";

  // redirect if already logged in
  if(isset($_SESSION['id'])) {
    if($_SESSION['role'] == 1) {
      header("Location: employer_dashboard.php");
    } elseif($_SESSION['role'] == 0) {
      header("Location: employee_dashboard.php");
    }
  }

  if(isset($_POST['submit'])) {
    echo "doge";
  }
?>

<div>
    <p style="color: red">Warning: Work in progress! Cannot log in yet.</p>
</div>

<div>
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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
    <form action="logout.php" method="get">
        <button type="submit">Logout</button>
    </form>
</div>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>

