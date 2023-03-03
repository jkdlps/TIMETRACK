<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Edit admin</h2>
</div>

<?php
// Get admin info from the database
$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM users WHERE id=$id AND role=1";
$result = mysqli_query($conn, $sql);

// Check if admin exists
if (mysqli_num_rows($result) == 0) {
    // Redirect 
    echo "<script>
    alert('Admin does not exist.');
    </script>";
    header("Location: employer_view_admins.php");
    exit();
}

// Get admin data
$admin_data = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Sanitize form inputs
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);

  // Update admin info in the database
  $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id AND role=1";
  if (mysqli_query($conn, $sql)) {
    // Redirect 
    header("Location: employer_view_admins.php");
    exit();
  } else {
    echo "Error updating admin info: " . mysqli_error($conn);
  }
}

// Close database connection
mysqli_close($conn);
?>

<!-- HTML form to edit admin info -->
<form method="POST">
  <label for="name">Name:</label>
  <input type="text" name="name" value="<?php echo $admin_data['name']; ?>"><br>
<label for="email">Email:</label>
<input type="email" name="email" value="<?php echo $admin_data['email']; ?>"><br>

<button type="submit">Update Admin Info</button>

</form>


<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>