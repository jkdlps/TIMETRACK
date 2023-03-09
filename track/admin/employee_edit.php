<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_SESSION['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];

  $conn = mysqli_connect('localhost', 'my_username', 'my_password', 'my_database');

  $query = "UPDATE users SET password='$password', email='$email' WHERE username='$username'";
  mysqli_query($conn, $query);

  mysqli_close($$conn);
}
?>

<form method="post">

<input type="email" name="email" placeholder="New Email">
  <input type="password" name="password" placeholder="New Password">

  <button type="submit">Update</button>
</form>





