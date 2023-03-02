<?php
include "conn.php";
include "header.php";
?>

<div>
    <h2>Employer Dashboard</h2>
    <h3>Welcome, <?php echo $_SESSION['user_name']; ?></h3>
    <form action="update-form.php" method="post">
        <button type="submit">Update Info</button>
    </form>
</div>

<div>
    <?php
    // Get attendance records for employee
    $query = "SELECT * FROM attendance WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $attendances = $result->fetch_all(MYSQLI_ASSOC);
    ?>
</div>

<div>
    <form action="dashboard.php" method="get">
        <button type="submit">View Dashboard as Employee</button>
    </form>
</div>

<div>
    <form action="logout.php" method="get">
        <button type="submit">Log Out</button>
    </form>
</div>