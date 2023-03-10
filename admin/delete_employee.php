<?php
session_start();
include "conn.php";
?>

<div>
    <h2>Delete Employee</h2>
</div>

<?php
// Get employee info from the database
$id = $_GET['id'];
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

// Delete employee info from the database
$sql = "DELETE FROM users WHERE id=$id";
if (mysqli_query($conn, $sql)) {
// Redirect
header("Location: employer_view_employees.php");
exit();
} else {
echo "Error deleting employee info: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>

