<?php
session_start();
include "../control/functions.php";
head("Edit Employee");
?>

<form method="post" action="../control/employee_edit.php" >
    <label for="password" class="form-label">New Password: </label>
    <input type="password" name="password" placeholder="New Password">
    <label for="email" class="form-label">New Email: </label>
    <input type="email" name="email" placeholder="New Email">
    <button type="submit">Update</button>
</form>