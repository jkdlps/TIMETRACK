<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];    

    db();
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    mysqli_query($con, $query);

    mysqli_close($con);
}

head("Sign Up");
?>

<div class="container-fluid text-center m-3 p-3">
    <form method="post" class="form-outline">
    
    <div class="form-group">
        <input type="email" class="form-control" name="email" class="form-control" placeholder="Email">
    </div>
    
    <div class="form-group">
        <input type="password" name="password" class="form-control" placeholder="Password">
    </div>

    <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>