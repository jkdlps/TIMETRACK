<?php 
include "header.php";
?>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>

<div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <button type="submit">Log In</button>
    </form>
</div>

<?php

if($_SERVER['POST']) {
    echo "test";
}