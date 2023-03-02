<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Employee Dashboard</h2>
    <h3>Welcome, <?php echo $_SESSION['user_name']; ?></h3>
</div>

<div>
    <form action="logout.php" method="get">
        <button type="submit">Log Out</button>
    </form>
</div>