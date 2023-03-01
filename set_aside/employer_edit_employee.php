<?php
// start session
session_start();

// include database connection
include('config.php');

// check if user is logged in as employer
if($_SESSION['role'] != 1) {
    header('Location: login.php');
    exit();
}

// retrieve all employees from database
$stmt = $conn->prepare("SELECT * FROM employees");
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// check if form was submitted to edit employee
if(isset($_POST['editEmployee'])) {
    // get employee details from form
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    // update employee in database
    $stmt = $conn->prepare("UPDATE employees SET name = :name, email = :email WHERE id = :id");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // redirect to employees page
    header('Location: employees.php');
    exit();
}

// check if form was submitted to delete employee
if(isset($_POST['deleteEmployee'])) {
    // get employee ID from form
    $id = $_POST['id'];

    // delete employee from database
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // redirect to employees page
    header('Location: employees.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employer - View Employees</title>
</head>
<body>
    <h1>Employer View Employees</h1>

    <p>Total Employees: <?php echo count($employees); ?></p>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach($employees as $employee) { ?>
        <tr>
            <td><?php echo $employee['name']; ?></td>
            <td><?php echo $employee['email']; ?></td>
            <td>
                <button onclick="editEmployee(<?php echo $employee['id']; ?>, '<?php echo $employee['name']; ?>', '<?php echo $employee['email']; ?>')">Edit</button>
                <form method="post" style="display: inline-block;">
                    <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">
                    <button type="submit" name="deleteEmployee">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>

    <button onclick="addEmployee()">Add Employee</button>

    <div id="editEmployeeModal" style="display: none;">
        <h2>Edit Employee</h2>
        <form method="post">
            <input type="hidden" id="id" name="id">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <button type="submit" name="editEmployee">Save</button>
        </form>
    </div>

    <div id="addEmployeeModal" style="display: none;">
        <h2

        <!-- Add Employee Modal -->
<div id="addEmployeeModal" style="display: none;">
    <h2>Add Employee</h2>
    <form method="post" action="add_employee.php">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Submit</button>
    </form>
</div>

<?php
// add_employee.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    
    // Insert employee into database
    $stmt = $pdo->prepare("INSERT INTO employees (name, email) VALUES (:name, :email)");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    
    // Redirect to employer dashboard after successful insertion
    header("Location: employer_dashboard.php");
    exit();
}
?>
<button onclick="document.getElementById('addEmployeeModal').style.display='block'">Add Employee</button>
