<?php
    session_start();
    if(isset($_SESSION['admin'])) {
        header("location: ../index.php");
    }

    include "../header.php";
?>

<div>
    <form action="login.php">
        <h1>Login</h1>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Log In</button>
    </form>
    <div>
        <?php 
            echo "<p>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        ?>
    </div>
</div>