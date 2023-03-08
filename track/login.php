<?php
session_start();
include "redirect.php";
include "functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
  
    db();
  
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);
  
    if (mysqli_num_rows($result) > 0) {
      $_SESSION['email'] = $email;
      header('Location: dashboard.php');
    } else {
      echo 'Invalid email or password';
    }
  
    mysqli_close($conn);
  }

head("Login");
?>

    <div class="container-fluid text-center">
        <div class="m-3 p-3">
            <h1>Login</h1>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="mt-3">
                    <label for="email" class="form-label">Email: </label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mt-3">
                    <label for="password" class="form-label">Password: </label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="mt-3">
                    <input type="submit" class="btn btn-primary" value="Log In">
                </div>
            </form>
            <div>
                <a href=""></a>
            </div>
        </div>
    </div>
</body>
</html>