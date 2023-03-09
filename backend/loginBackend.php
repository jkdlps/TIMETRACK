<?php

include("connection.php");

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$email = $_POST['email'];
$password = $_POST['password'];
$errors = array();

    // Escape input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Query database for user
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$hashed'";
    echo $sql;
    $result = mysqli_query($conn, $sql);

    // Check if user exists
    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
          $_SESSION["login"] = true;
          $_SESSION["id"] = $row["id"];
          header("location: ./usersindex.php");
      }
  }
    else {
      echo '<span style="color:#DC0000;text-align:center;">Invalid email or password.</span>';
    }

    mysqli_close($conn); // Close database connection

}

?>