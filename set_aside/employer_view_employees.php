<?php
// retrieve employee data from database
$stmt = $pdo->prepare("SELECT * FROM employees");
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// count total number of employees
$totalEmployees = count($employees);
?>

<h1>View Employees</h1>

<p>Total Employees: <?php echo $totalEmployees; ?></p>

<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($employees as $employee): ?>
      <tr>
        <td><?php echo $employee['name']; ?></td>
        <td><?php echo $employee['email']; ?></td>
        <td>
          <button onclick="location.href='edit_employee.php?id=<?php echo $employee['id']; ?>'">Edit</button>
          <button onclick="if (confirm('Are you sure you want to delete this employee?')) { location.href='delete_employee.php?id=<?php echo $employee['id']; ?>' }">Delete</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<button onclick="location.href='add_employee.php'">Add Employee</button>
