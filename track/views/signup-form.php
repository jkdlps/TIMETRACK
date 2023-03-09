<?php
session_start();
include "functions.php";
head("Sign Up");
?>

<div class="container-fluid text-center m-3 p-3">
    <form method="post" action="../signup.php" class="form-outline">
    
    <div class="form-group">
        <input type="email" class="form-control" name="email" class="form-control" placeholder="Email">
    </div>
    
    <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Password">
    </div>

    <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>