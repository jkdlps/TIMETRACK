<?php
session_start();
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

<?php
// Get the form data
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the user exists
$sql = "SELECT * FROM users WHERE email = '$email'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // Verify the password
  $row = mysqli_fetch_assoc($result);
  if (password_verify($password, $row['password'])) {
    // Set the session variables
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['user_name'] = $row['name'];
    // Redirect to the dashboard
    header('Location: dashboard.php');
  } else {
    echo "Invalid password";
  }
} else {
  echo "User not found";
}

mysqli_close($conn);