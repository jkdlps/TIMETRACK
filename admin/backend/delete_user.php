<?php

include "../TIMETRACK/control/connection.php";

if(isset($_POST['delete']))
{
    $id=$_POST['id'];
   

   // sql to delete a record
$sql = "DELETE FROM users WHERE id=$id";

if (mysqli_query($conn, $sql)) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . mysqli_error($conn);
}

    $conn->close();
}