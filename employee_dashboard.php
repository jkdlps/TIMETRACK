<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Employee Dashboard</h2>
    <h3>Welcome, <?php echo $_SESSION['user_name']; ?></h3>
    <form action="update-form.php" method="post">
        <button type="submit">Update Info</button>
    </form>
</div>

<?php
    if($_SESSION['user_role'] == 1) {
        echo "
        <div>
            <form action='employer_dashboard.php' method='post'>
                <button type='submit'>View Dashboard as Employer</button>
            </form>
        </div>";
    }
?>

<div>
    <form action="logout.php" method="get">
        <button type="submit">Log Out</button>
    </form>
</div>