<?php
session_start();
include "../control/functions.php";
head("Add Employee");
?>

<h1>Add Employee</h1>
    <?php if(isset($success_message)): ?>
        <p><?php echo $success_message; ?></p>
    <?php endif; ?>
    <form method="post" action="../control/employee_add.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="">Select a role</option>
            <option value="admin">Admin</option>
            <option value="employee">Employee</option>
        </select><br><br>
        <input type="submit" value="Add Employee">
    </form>