<?php
// connect to the database
$db_host = "localhost";
$db_username = "username";
$db_password = "password";
$db_name = "database";
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// handle approve/deny requests
if (isset($_POST['approve'])) {
    $user_id = $_POST['user_id'];
    $sql = "UPDATE users SET approved = 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
elseif (isset($_POST['deny'])) {
    $user_id = $_POST['user_id'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// get list of account requests
$sql = "SELECT id, name, email FROM users WHERE approved = 0";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Error fetching account requests: " . mysqli_error($conn));
}
?>

<!-- Account Requests Table -->
<h1>Account Requests</h1>
<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td>
            <form method="post">
                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                <button type="submit" name="approve">Approve</button>
                <button type="submit" name="deny">Deny</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php mysqli_close($conn); ?>
