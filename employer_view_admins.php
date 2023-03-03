<?php
session_start();
include "conn.php";
include "header.php";
?>
<div>
    <h2>Manage Admins</h2>
    <form action="employer_add_admin.php" method="post">
        <button type="submit">Add Admin</button>
    </form>
</div>

<div>
<?php
    // Retrieve all admins from the database
    $sql = "SELECT * FROM users WHERE role=1";
    $result = mysqli_query($conn, $sql);

    // Display total number of admins
    $num_rows = mysqli_num_rows($result);
    echo "<p>Total number of admins: $num_rows</p>";

    // Display table of admins
    echo "<table>";
    echo "<tr><th>Name</th><th>Email</th><th>Edit</th><th>Delete</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td><a href='employer_edit_employee.php?id=" . $row['id'] . "'>Edit</a></td>";
        echo "<td><a href='employer_delete_employee.php?id=" . $row['id'] . "'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";

    // Close database connection
    mysqli_close($conn);
?>
</div>

<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>