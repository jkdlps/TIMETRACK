<?php
session_start();
head("Password Hashing");
?>

<form action="../hash.php" method="post">
    <label for="password">Password: </label>
    <input type="password" name="password" id="password">
    <input type="submit" value="Hash">
</form>