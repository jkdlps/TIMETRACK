<?php
require_once "config.php";

// get employee ID from session variable (assuming it's stored there)
$employee_id = $_SESSION['employee_id'];

// get month and year from query string
$month = $_GET['month'];
$year = $_GET['year'];

// get start and end date of the month
$start_date = date('Y-m-d', strtotime($year . '-' . $month . '-01'));
$end_date = date('Y-m-t', strtotime($year . '-' . $month . '-01'));

// prepare SQL statement to retrieve daily time records for the month
$stmt = $conn->prepare("SELECT * FROM time_records WHERE employee_id = ? AND date >= ? AND date <= ?");
$stmt->bind_param("iss", $employee_id, $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();

// display daily time records in a table
echo "<table>";
echo "<tr><th>Date</th><th>Time In</th><th>Time Out</th></tr>";
while ($row = $result->fetch_assoc()) {
  echo "<tr><td>" . $row['date'] . "</td><td>" . $row['time_in'] . "</td><td>" . $row['time_out'] . "</td></tr>";
}
echo "</table>";

// close database connection
$conn->close();
?>
