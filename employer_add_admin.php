<?php
session_start();
include "conn.php";
include "header.php";

// if(!($_SESSION['role'] == 1)) {
//     header('location: employee_dashboard.php');
//     exit();
// }
?>

<div>
    <h2>Add Admin</h2>
</div>

<?php 
// Check if the form was submitted
if (isset($_POST['submit'])) {
  // Get the form data
  $name = $_POST['name'];
  $email = $_POST['email'];

  // Check if the user with the specified email exists
  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 1) {
    // Update the user's role to admin
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['id'];
    $sql = "UPDATE users SET role=1 WHERE id='$user_id'";
    mysqli_query($conn, $sql);

    // Close the database connection
    mysqli_close($conn);

    // Redirect to the dashboard
    header("Location: employer_dashboard.php");
    exit();
  } else {
    // Display an error message
    $error_msg = "User with email $email not found!";
  }
}
?>
    <?php if (isset($error_msg)) { ?>
      <p><?php echo $error_msg; ?></p>
    <?php } ?>
    <form method="post" action="add_admin.php">
      <label>Name:</label>
      <input type="text" name="name" required>
      <br>
      <label>Email:</label>
      <input type="email" name="email" required>
      <br>
      <button type="submit" name="submit">Add Admin</button>
    </form>
  </body>
</html>

?>

<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>