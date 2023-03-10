<?php

include("connection.php");

// Check if form is submitted
if (isset($_POST['submit'])) {
$email = $_POST['email'];
$password = $_POST['password'];

    // Query database for user
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if user exists
    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
          $_SESSION["login"] = true;
          $_SESSION["id"] = $row["id"];
          header("location: ../control/store_attendance.php");
      }
  }
    else {
      echo '<span style="color:#DC0000;text-align:center;">Invalid email or password.</span>';
    }

    mysqli_close($conn); // Close database connection

}

?>