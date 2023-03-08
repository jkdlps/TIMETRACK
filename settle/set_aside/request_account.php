<!DOCTYPE html>
<html>
<head>
	<title>Request Account</title>
</head>
<body>
	<h1>Request Account</h1>
	<form action="request_account_handler.php" method="POST">
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" required><br>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required><br>

		<input type="submit" value="Submit">
	</form>
</body>
</html>

<?php
// Connect to database
$db_host = 'localhost';
$db_name = 'your_db_name';
$db_user = 'your_db_username';
$db_pass = 'your_db_password';
$db_conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);

// Prepare SQL statement for inserting account request
$sql = "INSERT INTO account_requests (name, email, status) VALUES (?, ?, 0)";
$stmt = $db_conn->prepare($sql);

// Bind form data to SQL statement parameters
$stmt->bindParam(1, $_POST['name']);
$stmt->bindParam(2, $_POST['email']);

// Execute SQL statement
$stmt->execute();

// Send email with temporary password
$to = $_POST['email'];
$subject = 'Your account request has been received';
$message = 'Thank you for submitting your account request. Your request is currently being reviewed by our team. You will receive an email with further instructions once your account has been approved.\n\nTemporary password: ' . generateTemporaryPassword();
$headers = 'From: your_company_name <noreply@your_company_name.com>';

mail($to, $subject, $message, $headers);

// Redirect to confirmation page
header('Location: request_account_confirmation.php');
exit;

// Function for generating temporary password
function generateTemporaryPassword() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $temporary_password = '';
    for ($i = 0; $i < 10; $i++) {
        $temporary_password .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $temporary_password;
}