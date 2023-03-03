<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Your Leaves</h2>
</div>

<?php
// Get employee ID
$user_id = $_SESSION['user_id'];

// Check if leave request form is submitted
if (isset($_POST['start_date']) && isset($_POST['end_date']) && isset($_POST['reason'])) {
    // Get input values
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];

    // Calculate number of days between start and end dates
    $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);

    // Get remaining leave credit
    $sql = "SELECT leave_credit FROM users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $leave_credit = $row['leave_credit'];

    // Check if employee has enough leave credit
    if ($days > $leave_credit) {
        echo "Error: You don't have enough leave credit for $days day(s) of leave.";
    } else {
        // Insert leave request into database
        $sql = "INSERT INTO leaves (user_id, start_date, end_date, reason, status) VALUES ('$user_id', '$start_date', '$end_date', '$reason', 'Pending')";
        mysqli_query($conn, $sql);
        echo "Leave request submitted successfully.";
    }
}

// Display leave history
$sql = "SELECT * FROM leaves WHERE user_id = '$user_id' ORDER BY start_date DESC";
$result = mysqli_query($conn, $sql);

echo "<h2>Leave History</h2>";
echo "<table>";
echo "<tr><th>Start Date</th><th>End Date</th><th>Reason</th><th>Status</th><th>Request Approval</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . date('M d, Y', strtotime($row['start_date'])) . "</td>";
    echo "<td>" . date('M d, Y', strtotime($row['end_date'])) . "</td>";
    echo "<td>" . $row['reason'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    if ($row['status'] == 'Pending') {
        echo "<td><a href='employee_request_dtr.php?id=" . $row['id'] . "'>Request Approval</a></td>";
    } else {
        echo "<td></td>";
    }
    echo "</tr>";
}
echo "</table>";

// Display remaining leave credit
$sql = "SELECT leave_credit FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$leave_credit = $row['leave_credit'];
echo "<p>Remaining Leave Credit: $leave_credit day(s)</p>";

// Display leave request form
echo "<h3>Request Leave</h3>";
echo "<form method='post'>";
echo "<label for='start_date'>Start Date:</label>";
echo "<input type='date' id='start_date' name='start_date' required>";
echo "<br>";
echo "<label for='end_date'>End Date:</label>";
echo "<input type='date' id='end_date' name='end_date' required>";
echo "<br>";
echo "<label for='reason'>Reason:</label>";
echo "<input type='text' id='reason' name='reason' required>";
echo "<br>";
echo "<input type='submit' name='submit_leave' value='Submit'>";
echo "</form>";

if (isset($_POST['submit_leave'])) {
// Get form data
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$reason = $_POST['reason'];

// Check if leave dates are valid
$today = date('Y-m-d');
if ($start_date < $today || $end_date < $today || $end_date < $start_date) {
    echo "<p>Error: Invalid dates entered.</p>";
} else {
    // Calculate leave duration
    $start = strtotime($start_date);
    $end = strtotime($end_date);
    $duration = ($end - $start) / (60 * 60 * 24) + 1;

    // Check if employee has enough leave credit
    $sql = "SELECT * FROM employee_leave WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $leave_credit = $row['leave_credit'];
    if ($duration > $leave_credit) {
        echo "<p>Error: Not enough leave credit.</p>";
    } else {
        // Insert leave request into database
        $sql = "INSERT INTO leave_request (user_id, start_date, end_date, reason, status) VALUES ('$user_id', '$start_date', '$end_date', '$reason', 'Pending')";
        mysqli_query($conn, $sql);
        echo "<p>Leave request submitted.</p>";
    }
}
}

// Close database connection
mysqli_close($conn);
?>


<div>
    <form action='employee_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>