<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Employees On Leave</h2>
</div>



<?php
// Select employees on leave from database
$sql = "SELECT name, leave_start_date, leave_end_date, reason FROM employees WHERE on_leave = 1";
$result = mysqli_query($conn, $sql);

// Display table of employees on leave
if (mysqli_num_rows($result) > 0) {
    echo "<table><tr><th>Name</th><th>Leave Start Date</th><th>Leave End Date</th><th>Reason</th></tr>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row["name"] . "</td><td>" . $row["leave_start_date"] . "</td><td>" . $row["leave_end_date"] . "</td><td>" . $row["reason"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No employees on leave.";
}

// Close database connection
mysqli_close($conn);
?>


<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>