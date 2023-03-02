<?php
// Start the session
session_start();

// Connect to the database
include "header.php";
?>

<form method="post" action="update.php">
      <label>Name:</label>
      <input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>" required>
      <br>
      <label>Email:</label>
      <input type="email" name="email" value="<?php echo $_SESSION['user_email']; ?>" required>
      <br>
      <input type="submit" value="Update">
    </form>
  </body>
</html>

<?php
// Get the form data
$id = $_SESSION['user_id'];
$name = $_POST['name'];
$email = $_POST['email'];

// Update the user's information
$sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = '$id'";

if (mysqli_query($conn, $sql)) {
  // Update the session variables
  $_SESSION['user_name'] = $name;
  $_SESSION['user_email'] = $email;
  // Redirect to the dashboard
  header('Location: dashboard.php');
} else {
  echo "Error updating record: " . mysqli_error($conn);
}

mysqli_close($conn);