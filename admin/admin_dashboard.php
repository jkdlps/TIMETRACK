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
<?php include "view_employees.php"; ?>