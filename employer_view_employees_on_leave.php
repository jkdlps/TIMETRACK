<?php
// Connect to database
$conn = mysqli_connect("localhost", "username", "password", "database_name");

// Fetch list of employees on leave
$query = "SELECT * FROM leave_requests";
$result = mysqli_query($conn, $query);
?>

<!-- Display table of employees on leave -->
<h2>Employees on Leave</h2>
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Leave Start Date</th>
      <th>Leave End Date</th>
      <th>Reason for Leave</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
      <td><?php echo $row['employee_name']; ?></td>
      <td><?php echo $row['leave_start_date']; ?></td>
      <td><?php echo $row['leave_end_date']; ?></td>
      <td><?php echo $row['reason_for_leave']; ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
