<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Leave Requests</h2>
</div>

<!-- <div>
    <form action="employer_leave_request_approval.php" method="post">
        <button type="submit">Approve Leave Request</button>
    </form>
</div> -->

<?php
// Query to get leave requests
$sql = "SELECT * FROM leave_requests";

$result = mysqli_query($conn, $sql);

// Display table format of leave requests
if (mysqli_num_rows($result) > 0) {
    echo "<table>
            <tr>
                <th>Name</th>
                <th>Leave Start Date</th>
                <th>Leave End Date</th>
                <th>Reason for Leave</th>
                <th>Actions</th>
            </tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>".$row['name']."</td>
                <td>".$row['leave_start_date']."</td>
                <td>".$row['leave_end_date']."</td>
                <td>".$row['reason']."</td>
                <td><a href='employer_leave_request_approval.php?id=".$row['id']."'>Approve</a> / <a href='employer_leave_request_approval.php?id=".$row['id']."'>Deny</a></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No leave requests found.";
}

// Close database connection
mysqli_close($conn);
?>


<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>