<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];    

    db();

    $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    mysqli_query($con, $query);

    mysqli_close($con);
}

head("Sign Up");
?>

<div class="container-fluid text-center m-3 p-3">
    <form method="post" class="form-outline">
    <input type="text" class="form-control" name="username" placeholder="Username">
    <input type="password" name="password" class="form-label" placeholder="Password">
    <input type="email" class="form-control" name="email" class="form-label" placeholder="Email">
    <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>