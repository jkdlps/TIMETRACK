<?php
session_start();
include "header.php";
?>

<div>
    <h2>Update Your Information</h2>
    <form method="post" action="update.php">
        <label>New Name:</label>
        <input type="text" name="name" value="<?php echo $_SESSION['user_name']; ?>" required>
        <br>
        <label>New Email:</label>
        <input type="email" name="email" value="<?php echo $_SESSION['user_email']; ?>" required>
        <br>
        <input type="submit" value="Update">
    </form>
</div>

<?php
    if($_SESSION['user_role'] == 1) {
        echo "
        <div>
            <form action='employer_dashboard.php' method='post'>
                <button type='submit'>Back to Dashboard</button>
            </form>
        </div>";
    } elseif($_SESSION['user_role'] == 0) {
        echo "
        <div>
            <form action='employee_dashboard.php' method='post'>
                <button type='submit'>Back to Dashboard</button>
            </form>
        </div>";
    }
?>

</body>
</html>