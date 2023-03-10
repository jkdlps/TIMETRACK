<?php
session_start();
include "conn.php";
include "header.php";
?>
<!-- 
<div>
    <h2>Add Employee</h2>
    <form method="post" action="employer_add_employee.php">
        <label>Name:</label>
        <input type="text" name="name" required>
        <br>
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <input type="submit" value="Add Employee">
</form>
</div>

<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div> -->

<div>
    <h1>Add Employee</h1>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<label>Name:</label>
		<input type="text" name="name" required>
		<br>
		<label>Email:</label>
		<input type="email" name="email" required>
		<br>
		<input type="submit" value="Add Employee">
	</form>
</div>

<div>
  <form action='admin_dashboard.php' method='post'>
    <button type='submit'>Back to Dashboard</button>
  </form>
</div>

<?php
// Initialize variables
$name = "";
$email = "";
$password = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $name = sanitize($_POST["name"]);
  $email = sanitize($_POST["email"]);
  
  // Generate random password
  $password = bin2hex(random_bytes(5)); // Generates 10-character random password
  
  // Hash the password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  
  // Prepare and bind the statement
  $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $name, $email, $hashed_password);
  
  // Execute the statement
  if ($stmt->execute()) {
    echo "<script>alert('";
    echo "Employee added successfully! '<br>";
    echo "Name: " . $name . '<br>';
    echo "Email: " . $email . "'<br>";
    echo "Password: " . $password . "'<br>";
    echo "');</script>";
  } else {
    echo "<script>alert('Error: " . $stmt->error . "');</script>";
  }
  
  // Close the statement and connection
  $stmt->close();
  $conn->close();
}