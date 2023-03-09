<?php

include("connection.php");

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$email = $_POST['email'];
$password = $_POST['password'];
$errors = array();

    // Escape input to prevent SQL injection
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $password);

    // Query database for user
    $sql = "SELECT * FROM users WHERE email ='" . $email . "' AND password = '" . $password ."'";
    $result = mysqli_query($con, $sql);

    // Check if user exists
    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
          $_SESSION["login"] = true;
          $_SESSION["id"] = $row["id"];
          header("location: employee_dashboard.php");
        //   if($_SESSION['role'] == 0) {
        //     header("location: employee_dashboard.php");
        //   } else {
        //     header("location: admin_dashboard.php");
        //   }
      }
  }
    else {
      echo '<span style="color:#DC0000;text-align:center;">Invalid email or password.</span>';
    }

    mysqli_close($conn); // Close database connection

}

?>