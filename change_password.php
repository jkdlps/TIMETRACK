<?php
session_start();
require_once('config.php');

// If user is not logged in, redirect to login page
if(!isset($_SESSION['user_id'])){
    header('Location: login.php');
    exit;
}

// If form is submitted
if(isset($_POST['submit'])){
    // Get user id from session
    $user_id = $_SESSION['user_id'];
    
    // Get form data
    $previous_password = $_POST['previous_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Check if new password and confirm password match
    if($new_password !== $confirm_password){
        $error = 'New password and confirm password do not match.';
    }else{
        // Get user info from database
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
        
        // Verify previous password
        if(password_verify($previous_password, $user['password'])){
            // Update password in database
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([password_hash($new_password, PASSWORD_DEFAULT), $user_id]);
            
            // Redirect to login page
            header('Location: login.php');
            exit;
        }else{
            $error = 'Previous password is incorrect.';
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
</head>
<body>
    <?php if(isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
        <label>Previous Password:</label><br>
        <input type="password" name="previous_password" required><br>
        <label>New Password:</label><br>
        <input type="password" name="new_password" required><br>
        <label>Confirm New Password:</label><br>
        <input type="password" name="confirm_password" required><br>
        <input type="submit" name="submit" value="Change Password">
    </form>
</body>
</html>
