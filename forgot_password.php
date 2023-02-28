    <?php
    session_start();

    // Redirect to dashboard if already logged in
    if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] == 'employee') {
        header("Location: employee_dashboard.php");
    } else if ($_SESSION['user_type'] == 'employer') {
        header("Location: employer_dashboard.php");
    }
    exit();
    }

    require_once "conn.php";

    $email = "";
    $email_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Validate email
    if (empty($email)) {
        $email_err = "Please enter your email.";
    } else {
        $sql = "SELECT id FROM users WHERE email = ? AND user_type = 'employee'";
        if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $param_email);
        $param_email = $email;

        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
            $stmt->bind_result($id);
            $stmt->fetch();
            $stmt->close();

            // Generate one-time passcode
            $otp = mt_rand(100000, 999999);

            // Store one-time passcode in database
            $sql = "UPDATE users SET otp = ? WHERE id = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("si", $param_otp, $param_id);
                $param_otp = password_hash($otp, PASSWORD_DEFAULT);
                $param_id = $id;

                if ($stmt->execute()) {
                $stmt->close();

                // Send email containing one-time passcode
                $to = $email;
                $subject = "TIMETRACK Password Reset";
                $message = "Your one-time passcode for resetting your password is: " . $otp;
                $headers = "From: TIMETRACK";

                if (mail($to, $subject, $message, $headers)) {
                    header("Location: reset_password.php?email=" . $email);
                } else {
                    $email_err = "Failed to send email. Please try again later.";
                }
                } else {
                $email_err = "Something went wrong. Please try again later.";
                }
            } else {
                $email_err = "Something went wrong. Please try again later.";
            }
            } else {
            $email_err = "No account found with that email.";
            }
        } else {
            $email_err = "Something went wrong. Please try again later.";
        }
        } else {
        $email_err = "Something went wrong. Please try again later.";
        }

        $mysqli->close();
    }
    }
    include "header.php";
    ?>
    <h1>Forgot Password</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>">
        <span class="error"><?php echo $email_err; ?></span>
        <br>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
