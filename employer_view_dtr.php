<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Daily Time Records</h2>
</div>

<?php
// Get user ID
$user_id = $_GET['user_id'];

// Check if month and year are selected
if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];
} else {
    $month = date('m');
    $year = date('Y');
}

// Retrieve daily time records from database
$sql = "SELECT * FROM attendance WHERE user_id = '$user_id' AND MONTH(date) = '$month' AND YEAR(date) = '$year'";
$result = mysqli_query($conn, $sql);

// Display daily time records
echo "<h2>Daily Time Records for " . date('F Y', strtotime("$year-$month-01")) . "</h2>";
echo "<table>";
echo "<tr><th>Date</th><th>Clock In</th><th>Clock Out</th><th>Status</th><th>Edit</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . date('M d, Y', strtotime($row['date'])) . "</td>";
    echo "<td>" . date('h:i A', strtotime($row['clock_in'])) . "</td>";
    echo "<td>" . date('h:i A', strtotime($row['clock_out'])) . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td><a href='edit_dtr.php?id=" . $row['id'] . "'>Edit</a></td>";
    echo "</tr>";
}
echo "</table>";

// Display combobox for selecting month and year
echo "<form method='get'>";
echo "<input type='hidden' name='user_id' value='$user_id'>";
echo "<label for='month'>Select Month:</label>";
echo "<select id='month' name='month'>";
for ($i = 1; $i <= 12; $i++) {
    $month_name = date('F', strtotime("01-$i-01"));
    $selected = ($i == $month) ? "selected" : "";
    echo "<option value='$i' $selected>$month_name</option>";
}
echo "</select>";
echo "<label for='year'>Select Year:</label>";
echo "<select id='year' name='year'>";
for ($i = date('Y'); $i >= date('Y') - 5; $i--) {
    $selected = ($i == $year) ? "selected" : "";
    echo "<option value='$i' $selected>$i</option>";
}
echo "</select>";
echo "<input type='submit' value='Go'>";
echo "</form>";

// Display button for printing daily time record
echo "<br><div><button><a href='employer_print_dtr.php?user_id=$user_id&month=$month&year=$year'>Print Daily Time Record</a></button></div>";

// Close database connection
mysqli_close($conn);
?>

<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>