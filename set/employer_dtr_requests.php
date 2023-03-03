<?php
session_start();
include "conn.php";
include "header.php";
?>

<?php

// Retrieve all daily time record change requests
$sql = "SELECT * FROM dtr_changes JOIN users ON dtr_changes.user_id = users.id";
$result = mysqli_query($conn, $sql);

// Display daily time record change requests
echo "<h2>Daily Time Record Change Requests</h2>";
echo "<table>";
echo "<tr><th>Name</th><th>Date Requested</th><th>Original Date</th><th>Original Clock In</th><th>Original Clock Out</th><th>New Date</th><th>New Clock In</th><th>New Clock Out</th><th>Reason</th><th>Approve/Deny</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . date('M d, Y h:i A', strtotime($row['date_requested'])) . "</td>";
    echo "<td>" . date('M d, Y', strtotime($row['original_date'])) . "</td>";
    echo "<td>" . date('h:i A', strtotime($row['original_clock_in'])) . "</td>";
    echo "<td>" . date('h:i A', strtotime($row['original_clock_out'])) . "</td>";
    echo "<td>" . date('M d, Y', strtotime($row['new_date'])) . "</td>";
    echo "<td>" . date('h:i A', strtotime($row['new_clock_in'])) . "</td>";
    echo "<td>" . date('h:i A', strtotime($row['new_clock_out'])) . "</td>";
    echo "<td>" . $row['reason'] . "</td>";
    echo "<td><a href='employer_dtr_requests_approval.php?id=" . $row['id'] . "'>Approve</a> / <a href='employer_dtr_requests_approval.php?id=" . $row['id'] . "'>Deny</a></td>";
    echo "</tr>";
}
echo "</table>";

// Close database connection
mysqli_close($conn);
?>

<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>


<div>
    <form action="employer_dtr_requests_approval.php" method="post">
        <button type="submit">Approve Daily Time Record Request</button>
    </form>
</div>

<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>