<?php 
include "header.php";
?>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div>

<div>
    <h1>Login</h1>
    <?php
	if(isset($error)) {
		echo "<p>$error</p>";
	}
	?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Log In</button>
    </form>
    <div>
        <form action="request_account.php" method="get">
            <button type="submit">Request Account</button>
        </form>
    </div>
    <div>
        <form action="forgot_password.php" method="get">
            <button type="submit">Forgot Password</button>
        </form>
    </div>
</div>

<?php
include "conn.php";
session_start();

if (isset($_SESSION["email"])) {
    // if the user is already logged in, redirect to their respective dashboard
    if ($_SESSION["is_employer"] == 0) {
        header("Location: employee_dashboard.php");
    } else {
        header("Location: employer_dashboard.php");
    }
    exit();
}

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// process login form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // check if email is empty
    if (empty(sanitize($_POST["email"]))) {
        $email_err = "Please enter email.";
    } else {
        $email = sanitize($_POST["email"]);
    }

    // check if password is empty
    if (empty(sanitize($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = sanitize($_POST["password"]);
    }

    // validate credentials
    if (empty($email_err) && empty($password_err)) {
        // prepare a select statement
        $sql = "SELECT id, email, password, is_employer FROM users WHERE email = ?";

        if ($stmt = $conn->prepare($sql)) {
            // bind parameters to statement
            $stmt->bind_param("s", $param_email);

            // set parameters
            $param_email = $email;

            // attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();

                // check if email exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // bind result variables
                    $stmt->bind_result($id, $email, $hashed_password, $is_employer);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // password is correct, start a new session
                            session_start();

                            // store data in session variables
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["is_employer"] = $is_employer;

                            // redirect to respective dashboard
                            if ($is_employer == 0) {
                                header("Location: employee_dashboard.php");
                            } else {
                                header("Location: employer_dashboard.php");
                            }
                        } else {
                            // display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {
                    // display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            // close statement
            $stmt->close();
        }
    }
    // close connection
    $conn->close();
}