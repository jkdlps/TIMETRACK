<?php
session_start();
include "conn.php";
include "header.php";
?>

<?php
// Get request ID
$request_id = $_GET['id'];

// Retrieve request details
$sql = "SELECT * FROM dtr_changes WHERE id = '$request_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Display form for approving request
echo "<h2>Approve Daily Time Record Change Request</h2>";
echo "<form method='post' action='employer_approve_dtr_change_request_action.php'>";
echo "<input type='hidden' name='request_id' value='$request_id'>";
echo "<label for='date'>New Date:</label>";
echo "<input type='date' id='date' name='date' value='" . $row['new_date'] . "' required><br>";
echo "<label for='clock_in'>New Clock In:</label>";
echo "<input type='time' id='clock_in' name='clock_in' value='" . $row['new_clock_in'] . "' required><br>";
echo "<label for='clock_out'>New Clock Out:</label>";
echo "<input type='time' id='clock_out' name='clock_out' value='" . $row['new_clock_out'] . "' required><br>";
echo "<label for='reason'>Reason/Comment:</label>";
echo "<textarea id='reason' name='reason' required></textarea><br>";
echo "<label for='status'>Status:</label>";
echo "<select id='status' name='status'>";
echo "<option value='approved'>Approve</option>";
echo "<option value='denied'>Deny</option>";
echo "</select><br>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

// Close database connection
mysqli_close($conn);
?>


<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>