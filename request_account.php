<?php
// include the database connection file
include_once 'db_connection.php';

// initialize error variable
$error = '';

// check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // get input values from the form
  $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $one_time_passcode = mysqli_real_escape_string($conn, $_POST['one_time_passcode']);

  // check if the one-time passcode is valid
  $sql = "SELECT * FROM one_time_passcodes WHERE code = '$one_time_passcode'";
  $result = mysqli_query($conn, $sql);
  
  if (mysqli_num_rows($result) == 1) {
    // delete the one-time passcode from the database
    $sql = "DELETE FROM one_time_passcodes WHERE code = '$one_time_passcode'";
    mysqli_query($conn, $sql);

    // insert the employee data into the database
    $sql = "INSERT INTO employees (employee_id, name, email, password) VALUES ('$employee_id', '$name', '$email', '$password')";
    mysqli_query($conn, $sql);

    // redirect to login page with success message
    header("Location: login.php?success=account_request");
    exit();
  } else {
    $error = 'Invalid one-time passcode. Please try again.';
  }
}

// close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Request Account | TIMETRACK</title>
</head>
<body>
	<h1>Request Account</h1>
	
	<?php if ($error): ?>
	  <p style="color: red;"><?php echo $error; ?></p>
	<?php endif; ?>

	<form method="post">
		<label for="employee_id">Employee ID:</label>
		<input type="text" id="employee_id" name="employee_id" required><br><br>
		
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" required><br><br>
		
		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required><br><br>
		
		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required><br><br>
		
		<label for="one_time_passcode">One-Time Passcode:</label>
		<input type="text" id="one_time_passcode" name="one_time_passcode" required><br><br>
		
		<input type="submit" name="submit" value="Submit"><br><br>
	</form>
</body>
</html>
