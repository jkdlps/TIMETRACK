<?php

include "conn.php";

// Start session
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to appropriate dashboard based on user role
    if ($_SESSION['user_role'] == 'employee') {
        header('Location: employee_dashboard.php');
        exit;
    } elseif ($_SESSION['role'] == 'employer') {
        header('Location: employer_dashboard.php');
        exit;
    }
}

// Check if login form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate input
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];
    $errors = array();

    if (empty($email)) {
        $errors[] = 'Please enter your email.';
    }

    if (empty($password)) {
        $errors[] = 'Please enter your password.';
    }

    if (empty($role)) {
        $errors[] = 'Please select your user role.';
    }

    // Attempt to authenticate user
    if (empty($errors)) {

        // Prepare SQL statement
        $stmt = $mysqli->prepare('SELECT id, password FROM users WHERE email = ? AND role = ?');
        $stmt->bind_param('ss', $email, $role);

        // Execute SQL statement
        $stmt->execute();

        // Bind result variables
        $stmt->bind_result($user_id, $hashed_password);

        // Fetch result
        $stmt->fetch();

        // Close statement
        $stmt->close();

        // Close connection
        $mysqli->close();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_role'] = $user_role;

            // Redirect to appropriate dashboard based on user role
            if ($user_role == 'employee') {
                header('Location: employee_dashboard.php');
                exit;
            } elseif ($user_role == 'employer') {
                header('Location: employer_dashboard.php');
                exit;
            }
        } else {
            $errors[] = 'Invalid email or password.';
        }
    }
}