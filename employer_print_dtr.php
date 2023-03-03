<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Print Daily Time Record</h2>
</div>

<?php
// Get user id, month, and year from form
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : "";
$month = isset($_GET['month']) ? $_GET['month'] : date('n');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Display form for selecting user, month, and year
echo "<h3>Select Employee and Month/Year:</h3>";
echo "<form method='get'>";
echo "<label for='user_id'>Select Employee:</label>";
echo "<select id='user_id' name='user_id'>";
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $name = $row['name'];
    $selected = ($id == $user_id) ? "selected" : "";
    echo "<option value='$id' $selected>$name</option>";
}
echo "</select>";
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
for ($i = date('Y'); $i >= 2010; $i--) {
    $selected = ($i == $year) ? "selected" : "";
    echo "<option value='$i' $selected>$i</option>";
}
echo "</select>";
echo "<button type='submit'>View DTR</button>";
echo "</form>";

// If user id is not empty, get daily time records from database
if (!empty($user_id)) {
    $sql = "SELECT * FROM attendance WHERE user_id='$user_id' AND MONTH(date)='$month' AND YEAR(date)='$year' ORDER BY date ASC";
    $result = mysqli_query($conn, $sql);

    // Get user name
    $sql2 = "SELECT name FROM users WHERE id='$user_id'";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $name = $row2['name'];

    // Display DTR table
    echo "<h3>$name's Daily Time Record for " . date('F Y', strtotime("$year-$month-01")) . "</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Date</th><th>Time In</th><th>Time Out</th><th>Hours Worked</th><th>Edit</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $date = $row['date'];
        $time_in = $row['time_in'];
        $time_out = $row['time_out'];
        $hours_worked = $row['hours_worked'];
        echo "<tr>";
        echo "<td>" . date('Y-m-d', strtotime($date)) . "</td>";
        echo "<td>" . date('h:i A', strtotime($time_in)) . "</td>";
        echo "<td>" . date('h:i A', strtotime($time_out)) . "</td>";
        echo "<td>" . $hours_worked . "</td>";
        echo "<td><a href='employer_edit_dtr.php?id=$row[id]'>Edit</a></td>";
        echo "</tr>";
        }
        echo "</table>";
        }
        mysqli_close($conn);
        ?>

<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>