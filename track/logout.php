<?php
session_start();
session_unset();
session_destroy();
if($_SERVER['PHP_SELF'] == "dashboard.php") {
    header("location: login.php");
    exit();
} else {
    header("location: ../login.php");
    exit();
}
?>