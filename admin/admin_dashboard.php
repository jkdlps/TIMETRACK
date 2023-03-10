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

<a href="add_employee.php" class="btn btn-secondary">Add Employee</a>