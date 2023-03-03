<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Your Daily Time Records</h2>
</div>

<div>
    <form action="employer_print_dtr.php" method="post">
        <button type="submit">Print Daily Time Record</button>
    </form>
</div>

<?php
// Get employee ID
$user_id = $_SESSION['user_id'];

// Check if month is selected
if (isset($_GET['month'])) {
    $month = $_GET['month'];
} else {
    $month = date('m');
}

// Retrieve daily time records from database
$sql = "SELECT * FROM attendance WHERE user_id = '$user_id' AND MONTH(date) = '$month'";
$result = mysqli_query($conn, $sql);

// Display daily time records for the current month
echo "<h2>Daily Time Records for " . date('F Y', strtotime("01-$month-01")) . "</h2>";
echo "<table>";
echo "<tr><th>Date</th><th>Clock In</th><th>Clock Out</th><th>Status</th><th>Request Change</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . date('M d, Y', strtotime($row['date'])) . "</td>";
    echo "<td>" . date('h:i A', strtotime($row['clock_in'])) . "</td>";
    echo "<td>" . date('h:i A', strtotime($row['clock_out'])) . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td><a href='employee_request_dtr.php?id=" . $row['id'] . "'>Request Change</a></td>";
    echo "</tr>";
}
echo "</table>";

// Display dropdown for selecting month
echo "<h3>Select Month:</h3>";
echo "<form method='get'>";
echo "<select name='month'>";
for ($i = 1; $i <= 12; $i++) {
    $month_name = date('F', strtotime("01-$i-01"));
    $selected = ($i == $month) ? "selected" : "";
    echo "<option value='$i' $selected>$month_name</option>";
}
echo "</select>";
echo "<input type='submit' value='Go'>";
echo "</form>";

// Close database connection
mysqli_close($conn);
?>

<div>
    <form action='employee_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>