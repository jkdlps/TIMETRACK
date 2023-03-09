<?php
// Start the session
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Generate a random verification code
    $verification_code = rand(100000, 999999);
    
    // Store the user's data and verification code in the database
    include "conn.php";
    $stmt = mysqli_prepare($conn, "INSERT INTO users (email, password, verification_code) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'ssi', $email, $password, $verification_code);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    // Send an email to the user's email address with a link to verify their email address
    $to = $email;
    $subject = 'Email Verification Code';
    $message = 'Your email verification code is: ' . $verification_code;
    $headers = 'From: webmaster@example.com' . "\r\n" .
               'Reply-To: webmaster@example.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
    
    // Redirect the user to the email verification page
    header("Location: verify_email.php");
    exit();
}
?>
