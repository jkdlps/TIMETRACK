<?php
// session_start();
// // include "functions.php";
// $con = mysqli_connect("localhost", "u947188626_timetrack", "|5FnHl7#", "u947188626_timetrack");

// if (isset($_POST['submit'])) {
//     $email = $_POST['email'];

//     $password = password_verify($_POST['password'], PASSWORD_DEFAULT);

//     $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
//     $result = mysqli_query($con, $query);
//     if (mysqli_num_rows($result) > 0) {
//         $_SESSION['email'] = $email;
//         header('Location: employee_dashboard.php');
//     } else {
//         echo 'Invalid email or password';
//         header("location: ../loginpage.php");
//     }

//     mysqli_close($con);
// }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Timetrack</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">


    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<body>

    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div class="row align-items-center g-lg-5 py-5">

            <div class="col-lg-6 text-center text-lg-start">
                <img class="img-fluid" src="./images/login.png" />
            </div>
            <div class="col-md-10 mx-auto col-lg-6">

                <form class="p-4 p-md-5  rounded-3" method="post">
                    
                    <?php
                    // include("./backend/loginbackend.php");
                    ?>

                    <h1 class="my-2">Login</h1>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="email"
                            placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" name="password"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary mb-3" type="submit" value="Login">Login</button>
                    <small class="text-muted">Don't have an account?<a href="./loginpage.php"> Sign Up </a></small>
                    <hr class="my-4">
                    <small class="text-muted mb-3"> By using this service, you understood and agree to the Linawan
                        Christian Church <a href="terms.php"> Terms of Use and Privacy Statement</small>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>


========================================================================================================================



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

    // Query database for user
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if user exists
    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
          $_SESSION["login"] = true;
          $_SESSION["id"] = $row["id"];
          if($_SESSION['role'] == 0) {
            header("location: employee_dashboard.php");
          } else {
            header("location: admin_dashboard.php");
          }
      }
  }
    else {
      echo '<span style="color:#DC0000;text-align:center;">Invalid email or password.</span>';
    }

    mysqli_close($conn); // Close database connection

}

?>

