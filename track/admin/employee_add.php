<?php
// Start session
session_start();

// Check if user is logged in and is an admin
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Include database connection file
include "../functions.php";
db();

// Check if the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Insert the employee into the database
    $stmt = $conn->prepare("INSERT INTO employees (set_id, firstname, lastname, designation) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $set_id, $firstname, $lastname, $designation);
    $stmt->execute();
    $success_message = alerter("Employee added successfully.", "success");

    // Close statement
    $stmt->close();
}
// Close database connection
$conn->close();

head("Add Employee");
?>
    <h1>Add Employee</h1>
    <?php if(isset($success_message)): ?>
        <p><?php echo $success_message; ?></p>
    <?php endif; ?>
    <form method="post">
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
</body>
</html>
