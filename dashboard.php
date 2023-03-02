<?php
session_start();
include "header.php";
?>
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?></h1>
    <p>Your email is: <?php echo $_SESSION['user_email']; ?></p>

<div>
    <form action="logout.php" method="get">
        <button type="submit">Log Out</button>
    </form>
</div>