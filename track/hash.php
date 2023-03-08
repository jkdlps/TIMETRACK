<?php
session_start();
include "functions.php";
$password = $_POST['password'];
$hashed = password_hash($password, PASSWORD_DEFAULT);

head("Password Hashing");
?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="password">Password: </label>
    <input type="password" name="password" id="password">
    <input type="submit" value="Hash">
    </form>
</body>
</html>