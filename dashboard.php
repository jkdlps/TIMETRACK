<?php
session_start();
include "conn.php";
include "header.php";
?>
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?></h1>

<div>
    <form action="logout.php" method="get">
        <button type="submit">Log Out</button>
    </form>
</div>