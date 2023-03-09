<?php
session_start();
include "connection.php";
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

// Display daily time records for the selected month and year
echo "<h2>Daily Time Records for " . date('F Y', strtotime("$year-$month-01")) . "</h2>";
echo "<table>";
echo "<tr><th>Date</th><th>Clock In</th><th>Clock Out</th><th>Status</th><th>Request Change</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . date('M d, Y', strtotime($row['date'])) . "</td>";
    echo "<td>" . date('h:i A', strtotime($row['clock_in'])) . "</td>";
    echo "<td>" . date('h:i A', strtotime($row['clock_out'])) . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td><a href='request_change.php?id=" . $row['id'] . "'>Request Change</a></td>";
    echo "</tr>";
}
echo "</table>";

// Display dropdowns for selecting month and year
echo "<h3>Select Month and Year:</h3>";
echo "<form method='get'>";
echo "<select name='month'>";
for ($i = 1; $i <= 12; $i++) {
    $month_name = date('F', strtotime("01-$i-01"));
    $selected = ($i == $month) ? "selected" : "";
    echo "<option value='$i' $selected>$month_name</option>";
}
echo "</select>";
echo " ";
echo "<select name='year'>";
for ($i = date('Y'); $i >= 2020; $i--) {
    $selected = ($i == $year) ? "selected" : "";
    echo "<option value='$i' $selected>$i</option>";
}
echo "</select>";
echo "<input type='submit' value='Go'>";
echo "</form>";

// Check if request DTR change form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];

    // Insert new DTR change request into database
    $sql = "INSERT INTO dtr_changes (user_id, date, time, reason) VALUES ('$user_id', '$date', '$time', '$reason')";
    if (mysqli_query($conn, $sql)) {
        echo "<p>DTR change request submitted successfully!</p>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Display request DTR change form
echo "<h3>Request DTR Change</h3>";
echo "<form method='post'>";
echo "<label for='date'>Date:</label>";
echo "<input type='date' id='date' name='date' required><br>";
echo "<label for='time'>Time:</label>";
echo "<input type='time' id='time' name='time' required><br>";
echo "<label for='reason'>Reason:</label>";
echo "<textarea id='reason' name='reason' required></textarea><br>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

// Close database connection
mysqli_close($conn);
?>


<div>
    <form action='employee_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>