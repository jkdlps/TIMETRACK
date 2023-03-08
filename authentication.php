<?php
// Start session
session_start();

// Check if user is already logged in
if(isset($_SESSION['user_id'])) {
    header("Location: employee_panel.php");
    exit;
}

// Check if the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Include database connection file
    require_once "db_connection.php";

    // Prepare and bind parameters to the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Set parameters and execute the statement
    $email = $_POST['email'];
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($user_id, $email, $hashed_password);

    // Check if there is a match for the email
    if($stmt->fetch()) {
        // Verify the entered password with the hashed password from the database
        if(password_verify($_POST['password'], $hashed_password)) {
            // Store the user ID in the session variable
            $_SESSION['user_id'] = $user_id;
            // Redirect to the employee panel page
            header("Location: employee_panel.php");
            exit;
        }
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();

    // Display error message
    $error_message = "Invalid email or password.";
}
?>