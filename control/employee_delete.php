<?php
session_start();
include "../functions.php";

$email = $_SESSION['email'];

db();

$query = "DELETE FROM users WHERE email='$email'";
mysqli_query($con, $query);

mysqli_close($con);

session_unset();
session_destroy();

header('Location: index.php');
?>