<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include conn file
require_once "conn.php";

// Define variables and initialize with empty values
$name = $email = $employee_id = "";

// Prepare a select statement
$sql = "SELECT name, email, employee_id FROM employees WHERE id = ?";

if($stmt = $conn->prepare($sql)){
    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("i", $param_id);

    // Set parameters
    $param_id = $_SESSION["id"];

    // Attempt to execute the prepared statement
    if($stmt->execute()){
        // Store result
        $stmt->store_result();

        // Check if username exists, if yes then verify password
        if($stmt->num_rows == 1){
            // Bind result variables
            $stmt->bind_result($name, $email, $employee_id);
            if($stmt->fetch()){
                // Display user information
            }
        } else{
            // Redirect to login page
            header("location: login.php");
            exit;
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();

include "header.php";
?>
    <div class="wrapper">
        <h1>Employee Dashboard</h1>
        <h2>Welcome, <?php echo $name; ?></h2>
        <p>Your employee ID is: <?php echo $employee_id; ?></p>
        <p>Your email address is: <?php echo $email; ?></p>
    </div>
    <div>
        <form action="logout.php" method="post">
            <input type="submit" value="Log Out">
        </form>
    </div>
</body>
</html>
