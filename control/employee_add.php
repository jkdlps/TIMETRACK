<?php
// Start session
session_start();

// Check if user is logged in and is an admin
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] == 0) {
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
?>


</body>
</html>
