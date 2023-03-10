<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Manage Employees</h2>
	<a href="add_employee.php" class="btn btn-secondary">Add Employee</a>
	<?php
		// Retrieve all employees from the database
		$sql = "SELECT * FROM users";
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