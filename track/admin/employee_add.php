<?php
// Start session
session_start();

// Check if user is logged in and is an admin
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Include database connection file
require_once "../config.php";

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
    $success_message = '
    <div class="alert alert-success">
        <p>Employee added successfully.</p>
    </div>';

    // Close statement
    $stmt->close();
}
// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee | Timetrack</title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
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
