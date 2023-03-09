<?php
session_start();
include "../control/functions.php";
head("Password Hashing");
?>

<form action="../control/hash.php" method="post">
    <label for="password">Password: </label>
    <input type="password" name="password" id="password">
    <input type="submit" value="Hash">
</form>