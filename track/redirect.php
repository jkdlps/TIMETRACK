<?php
if(isset($_SESSION['user_id'])) {
    if($_SESSION['user_role'] == 1) {
        header("location: admin/dashboard.php");
        exit();
    } elseif($_SESSION['user_role'] == 0) {
        header("location: dashboard.php");
        exit();
    }
}
?>