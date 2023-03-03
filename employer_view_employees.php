<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Employees</h2>
    <form action="employer_add_employee.php" method="post">
        <button type="submit">Add Employee</button>
    </form>
    <h2>View Employees</h2>
	<?php
		// Retrieve all employees from the database
		$sql = "SELECT * FROM employees";
		$result = mysqli_query($conn, $sql);

		// Display total number of employees
		$num_rows = mysqli_num_rows($result);
		echo "<p>Total number of employees: $num_rows</p>";

		// Display table of employees
		echo "<table>";
		echo "<tr><th>Name</th><th>Email</th><th>Edit</th><th>Delete</th></tr>";
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>" . $row['name'] . "</td>";
			echo "<td>" . $row['email'] . "</td>";
			echo "<td><a href='edit_employee.php?id=" . $row['id'] . "'>Edit</a></td>";
			echo "<td><a href='delete_employee.php?id=" . $row['id'] . "'>Delete</a></td>";
			echo "</tr>";
		}
		echo "</table>";

		// Close database connection
		mysqli_close($conn);
	?>
</div>

<div>

    <h2>Manage Admins</h2>
    <form action="employer_add_admin.php" method="post">
        <button type="submit">Add Admin</button>
    </form>
    <form action="employer_remove_admin.php" method="post">
        <button type="submit">Remove Admin</button>
    </form>
</div>

<div>
    <h2>Navigation</h2>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>