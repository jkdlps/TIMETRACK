<?php
// Establish database connection
require_once('header.php');

// Initialize variables
$name = '';
$email = '';
$password = '';
$employer_id = ''; // this will be assigned by the employer
$errors = array();

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Validate form inputs
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $employer_id = mysqli_real_escape_string($conn, $_POST['employer_id']);

  if (empty($name)) { array_push($errors, 'Name is required'); }
  if (empty($email)) { array_push($errors, 'Email is required'); }
  if (empty($password)) { array_push($errors, 'Password is required'); }

  // Check if email already exists in the database
  $check_email_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
  $result = mysqli_query($conn, $check_email_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // If email exists, add error message to errors array
    array_push($errors, 'Email already exists');
  }

  // If no errors, insert new user to database
  if (count($errors) == 0) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO users (name, email, password, employer_id, role, created_on) 
              VALUES('$name', '$email', '$hashed_password', '$employer_id', 0, NOW())";
    mysqli_query($conn, $query);

    // Redirect to login page
    header('location: login.php');
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
</head>
<body>
  <h2>Register</h2>
  
  <?php if (count($errors) > 0): ?>
    <div>
      <?php foreach ($errors as $error): ?>
        <p><?php echo $error; ?></p>
      <?php endforeach ?>
    </div>
  <?php endif ?>
  
  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <div>
      <label for="name">Name</label>
      <input type="text" name="name" value="<?php echo $name; ?>">
    </div>
    <div>
      <label for="email">Email</label>
      <input type="email" name="email" value="<?php echo $email; ?>">
    </div>
    <div>
      <label for="password">Password</label>
      <input type="password" name="password">
    </div>
    <div>
      <label for="employer_id">Employer ID</label>
      <input type="text" name="employer_id" value="<?php echo $employer_id; ?>">
    </div>
    <div>
      <button type="submit">Register</button>
    </div>
  </form>
</body>
</html>
