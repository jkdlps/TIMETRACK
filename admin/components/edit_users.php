<?php
// include "../TIMETRACK/control/connection.php";

// $id = $_GET['GETid'];

// $sql = "SELECT * FROM users WHERE id =$id";

// $result=mysqli_query($conn,$sql);
// $row = mysqli_fetch_assoc($result);

// $id=$row['id'];
// $firstname=  $row['firstname'];
// $lastname= $row['lastname'];
// $contact= $row['contact'];
// $address= $row['address'];
// $gender= $row['gender'];
// $email= $row['email'];
// $password=$row['password'];
?>

<?php
session_start();
include "../backend/connection.php";
include "../TIMETRACK/backend/message.php";
?>

<div>
    <h2>Edit Admin</h2>
</div>

<?php
// Get admin info from the database
$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($conn, $sql);

// Check if admin exists
if (mysqli_num_rows($result) == 0) {
    // Redirect 
    $_SESSION['message'] = "No results found.";
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