<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Edit Employee</h2>
</div>

<?php
// Get employee info from the database
$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($conn, $sql);

// Check if employee exists
if (mysqli_num_rows($result) == 0) {
    // Redirect 
    echo "<script>
    alert('Employee does not exist.');
    </script>";
    header("Location: employer_dashboard.php");
    exit();
}

// Get employee data
$employee_data = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Sanitize form inputs
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);

  // Update employee info in the database
  $sql = "UPDATE employees SET name='$name', email='$email' WHERE id=$id";
  if (mysqli_query($conn, $sql)) {
    // Redirect 
    header("Location: employer_view_employees.php");
    exit();
  } else {
    echo "Error updating employee info: " . mysqli_error($conn);
  }
}

// Close database connection
mysqli_close($conn);
?>

<!-- HTML form to edit employee info -->
<form method="POST">
  <label for="name">Name:</label>
  <input type="text" name="name" value="<?php echo $employee_data['name']; ?>"><br>
<label for="email">Email:</label>
<input type="email" name="email" value="<?php echo $employee_data['email']; ?>"><br>

<button type="submit">Update Employee Info</button>

</form>


<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>