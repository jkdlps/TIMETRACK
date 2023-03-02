<?php
include "header.php";
?>
<h2>Signup</h2>
    <form method="post" action="signup.php">
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Password:</label>
        <input type="password" name="password" required>
        <br>
        <label>Name:</label>
        <input type="text" name="name" required>
        <br>
        <input type="submit" value="Signup">
    </form>
</body>
</html>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>

<?php

// Get the form data
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$name = $_POST['name'];

// Insert the user into the database
$sql = "INSERT INTO users (email, password, name) VALUES ('$email', '$password', '$name')";

if (mysqli_query($conn, $sql)) {
  echo "User created successfully";
} else {
  echo "Error: " . mysqli_error($conn);
}
mysqli_close($conn);