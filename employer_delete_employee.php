<?php
// Include database connection
include('db_connect.php');

// Delete employee if delete button is clicked and confirmation is received
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    // Prepare and execute the SQL statement to delete the employee record
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Close prepared statement and database connection
    $stmt->close();
    $conn->close();

    // Redirect to the same page to refresh employee list
    header('Location: employer.php');
    exit;
}

// Retrieve employee data from database
$sql = "SELECT id, name, email FROM employees";
$result = $conn->query($sql);

// Display total number of employees
$num_employees = $result->num_rows;
echo "<p>Total Employees: $num_employees</p>";

// Display employee list in table format
echo "<table>";
echo "<tr><th>Name</th><th>Email</th><th>Edit</th><th>Delete</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row["name"] . "</td>";
    echo "<td>" . $row["email"] . "</td>";
    echo "<td><button onclick=\"editEmployee(" . $row["id"] . ")\">Edit</button></td>";
    echo "<td><button onclick=\"confirmDelete(" . $row["id"] . ")\">Delete</button></td>";
    echo "</tr>";
}
echo "</table>";

// Close database connection
$conn->close();
?>

<!-- Add Employee Modal Form -->
<div id="addEmployeeModal" style="display: none;">
    <h2>Add Employee</h2>
    <form method="post" action="add_employee.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Add</button>
        <button type="button" onclick="closeModal()">Cancel</button>
    </form>
</div>

<!-- Edit Employee Modal Form -->
<div id="editEmployeeModal" style="display: none;">
    <h2>Edit Employee</h2>
    <form method="post" action="edit_employee.php">
        <input type="hidden" id="edit_id" name="id">

        <label for="edit_name">Name:</label>
        <input type="text" id="edit_name" name="name" required>

        <label for="edit_email">Email:</label>
        <input type="email" id="edit_email" name="email" required>

        <button type="submit">Save</button>
        <button type="button" onclick="closeModal()">Cancel</button>
    </form>
</div>

<!-- Delete Employee Modal Form -->
<div id="deleteEmployeeModal" style="display: none;">
    <h2>Confirm Deletion</h2>
    <p>Are you sure you want to delete this employee?</p>
    <form method="post">
        <input type="hidden" id="delete_id" name="delete_id">
        <button type="submit">Delete</button>
        <button type="button" onclick="closeModal()">Cancel</button>
    </form>
</div>

<?php
// Check if delete form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    // Prepare delete statement
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $_POST['delete_id']);
    
    // Execute delete statement
    if ($stmt->execute()) {
        // Redirect to employees page
        header("Location: employees.php");
        exit();
    } else {
        // Display error message if delete failed
        echo "Error deleting employee: " . $conn->error;
    }
}

// Fetch employees from database
$result = $conn->query("SELECT * FROM employees");

// Display total number of employees
$numEmployees = $result->num_rows;
echo "<p>Total Employees: $numEmployees</p>";

// Display table of employees
echo "<table>";
echo "<tr><th>Name</th><th>Email</th><th>Actions</th></tr>";

while ($row = $result->fetch_assoc()) {
    // Display each employee row
    echo "<tr><td>" . $row['name'] . "</td><td>" . $row['email'] . "</td><td>";
    
    // Display edit and delete buttons for each employee
    echo "<button onclick=\"location.href='edit_employee.php?id=" . $row['id'] . "'\">Edit</button>";
    echo "<button onclick=\"showDeleteModal(" . $row['id'] . ")\">Delete</button>";
    
    echo "</td></tr>";
}

echo "</table>";
?>

<script>
// Function to show delete employee modal and set the employee ID to be deleted
function showDeleteModal(id) {
    document.getElementById("delete_id").value = id;
    document.getElementById("deleteEmployeeModal").style.display = "block";
}

// Function to close the currently visible modal
function closeModal() {
    var modals = document.getElementsByClassName("modal");
    for (var i = 0; i < modals.length; i++) {
        modals[i].style.display = "none";
    }
}
</script>

