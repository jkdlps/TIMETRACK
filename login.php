<form method="POST" action="login.php">
    <label for="email">Email:</label>
    <input type="email" name="email" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <br>
    <label for="remember">Remember me:</label>
    <input type="checkbox" name="remember">
    <br>
    <input type="submit" value="Login">
</form>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) && $_POST['remember'] === 'on';

    // Connect to database
    $db = mysqli_connect('localhost', 'username', 'password', 'dbname');

    // Query user by email
    $query = mysqli_prepare($db, "SELECT * FROM users WHERE email = ?");
    mysqli_stmt_bind_param($query, "s", $email);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);
    $user = mysqli_fetch_assoc($result);

    // Check password and role
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];

        if ($remember) {
        // Generate and save remember token
        $remember_token = bin2hex(random_bytes(50));
        $query = mysqli_prepare($db, "UPDATE users SET remember_token = ? WHERE id = ?");
        mysqli_stmt_bind_param($query, "si", $remember_token, $user['id']);
        mysqli_stmt_execute($query);
        setcookie('remember_token', $remember_token, time() + (30 * 24 * 60 * 60), '/');
        }

        if ($user['role'] === 1) {
        // Redirect to employer dashboard
        header('Location: employer_dashboard.php');
        } else {
        // Redirect to employee dashboard
        header('Location: employee_dashboard.php');
        }
        exit;
    } else {
        // Display error message
        $error = "Invalid email or password";
    }
}
?>
