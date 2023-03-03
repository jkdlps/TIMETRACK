<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve current password from database
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];

    // Retrieve user's current password from database
    $sql = "SELECT password FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $db_password = $row['password'];

        // Check if entered password matches current password
        if (password_verify($current_password, $db_password)) {
            // Update password in database
            $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = '$new_password' WHERE id = $user_id";
            mysqli_query($conn, $sql);

            // Redirect to dashboard with success message
            $_SESSION['success'] = "Password updated successfully.";
            header("Location: dashboard.php");
            exit();
        } else {
            // Show error message
            $error = "Current password is incorrect.";
        }
    } else {
        // Show error message
        $error = "User not found.";
    }

    mysqli_close($conn);
}
include "header.php";
?>
    <?php if (isset($error)) { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form method="post">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" required><br>

        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required><br>

        <input type="submit" value="Update Password">
    </form>
</body>
</html>
