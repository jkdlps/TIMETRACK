<?php
session_start();
include "connection.php";

$errors = array(); // Initialize an empty array to store validation errors

if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password_confirmation = mysqli_real_escape_string($conn, $_POST['password_confirmation']);

    // Validate password
    if (strlen($password) < 8) {
        $errors['password'] = "Password should be at least 8 characters long.";
    } elseif (!preg_match("#[0-9]+#", $password)) {
        $errors['password'] = "Password should contain at least one digit.";
    } elseif (!preg_match("#[a-zA-Z]+#", $password)) {
        $errors['password'] = "Password should contain at least one letter.";
    } elseif ($password !== $password_confirmation) {
        $errors['password'] = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    if (count($errors) === 0) { // If there are no validation errors
        $sql = "INSERT INTO users (firstname, lastname, email, password, role, designation)
        VALUES ('$firstname', '$lastname', '$email', '$password', '$role', '$designation')";

        if ($conn->query($sql) === TRUE) {
            header('Location: ../usersPage.php');
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $conn->close();
    }
}
?>

<?php
// session_start();
// include "connection.php";

// if (isset($_POST['submit'])) {
//     $firstname = $_POST['firstname'];
//     $lastname = $_POST['lastname'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $role = $_POST['role'];
//     $designation = $_POST['designation'];

//     $sql = "INSERT INTO users (firstname, lastname, email, password, role, designation)
//             VALUES ('$firstname', '$lastname', '$email', '$password', '$role', '$designation')";

//     if ($conn->query($sql) === TRUE) {
//         alerter("success", "Successfully added employee");
//         header("location: ../usersPage.php");
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//         alerter("danger", "Error: $sql <br> $conn->error");
//     }
// }
// $conn->close();
?>
