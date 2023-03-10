<?php
session_start();
include "../control/connection.php";

if($_SESSION['role'] == 0) {
  exit("
  <script>
    alert('For admins only');
  </script>
  ");
  
}
?>

<h3>Manage Employees</h3>
<?php include "view_employees.php"; ?>
<a href="add_employee.php" class="btn btn-secondary">Add Employee</a>