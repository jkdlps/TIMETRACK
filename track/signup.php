<?php
// Start session
session_start();

include "redirect.php";

// Include database connection file
require_once "config.php";

// Initialize variables for input validation
$name = $email = $password = $confirm_password = "";
$name_err = $email_err = $password_err = $confirm_password_err = "";

// Check if the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if(empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if(empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $param_email);
        $param_email = trim($_POST["email"]);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows == 1) {
            $email_err = "This email is already taken.";
        } else {
            $email = trim($_POST["email"]);
        }
        $stmt->close();
    }

    // Validate password
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Passwords did not match.";
        }
    }

    // Check input errors before inserting into database
    if(empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);
        if($stmt->execute()) {
            // Redirect to login page
            header("Location: login.php");
            exit;
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
}
