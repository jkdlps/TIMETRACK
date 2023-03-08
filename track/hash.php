<?php
session_start();
include "config.php";
$password = $_POST['password'];
$hashed = password_hash($password, PASSWORD_DEFAULT);

echo "The hashed password is: " . var_dump($hashed);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hashing Passwords | Timetrack</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <label for="password">Password: </label>
    <input type="password" name="password" id="password">
    </form>
</body>
</html>