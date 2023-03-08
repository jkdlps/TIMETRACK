<?php
session_start();
include "conn.php";
?>

<div>
    <h2>Delete Admin</h2>
</div>

<?php
// Get admin info from the database
$id = $_GET['id'];
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

// Delete admin info from the database
$sql = "DELETE FROM users WHERE id=$id AND role=1";
if (mysqli_query($conn, $sql)) {
// Redirect
header("Location: employer_view_admins.php");
exit();
} else {
echo "Error deleting admin info: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>

