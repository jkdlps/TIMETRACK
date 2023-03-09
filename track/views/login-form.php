<?php
session_start();
include "functions.php";
head("Login");
?>

<div class="container-fluid text-center">
    <div class="m-3 p-3">
        <h1>Login</h1>
        <form action="../login.php" method="post">
            <div class="mt-3">
                <label for="email" class="form-label">Email: </label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mt-3">
                <label for="password" class="form-label">Password: </label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mt-3">
                <input type="submit" class="btn btn-primary" value="Log In">
            </div>
        </form>
        <div>
            <a href=""></a>
        </div>
    </div>
</div>