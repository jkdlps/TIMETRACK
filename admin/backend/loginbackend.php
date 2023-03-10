<?php

session_start();


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$email = $_POST['email'];
$password = $_POST['password'];


if (isset($_POST['submit'])) {
    // Query database for user
    $sql = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
 
 

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo 'Hello';

      // set session variables
    $_SESSION['email'] = $email;
    $_SESSION['loggedin'] = true;
    
      header("location: ../home.php");
    }
  } else {
    echo "0 results";
  }
}
?>