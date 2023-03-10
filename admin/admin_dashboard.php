<?php
session_start();
include "../control/connection.php";

if($_SESSION['role'] == 0) {
  die("
  <script>
    alert('For admins only');
  </script>
  ");

  
}
?>

