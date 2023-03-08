<?php
session_start();
include "redirect.php";

// Check if the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    include "config.php";

    // Prepare and bind parameters to the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Set parameters and execute the statement
    $email = $_POST['email'];
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($user_id, $email, $hashed_password);

    // Check if there is a match for the email
    if($stmt->fetch()) {
        // Verify the entered password with the hashed password from the database
        if(password_verify($_POST['password'], $hashed_password)) {
            // Store the user ID in the session variable
            $_SESSION['user_id'] = $user_id;
            // Redirect to the employee panel page
            if($_SESSION['user_role'] == 1) {
                header("location: admin/dashboard.php");
                exit();
            } elseif($_SESSION['user_role'] == 0) {
                header("location: dashboard.php");
                exit();
            } else {
                echo "Log in failed.";
            }
        }
    } else {
        echo "Fetching data from database failed.";
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();

    // Display error message
    $error_message = "Invalid email or password.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Timetrack</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
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
        </div>
    </div>
</body>
</html>