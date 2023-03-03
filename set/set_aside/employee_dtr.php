<?php
session_start();

// Check if user is logged in and is an employee
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 0) {
    header('Location: login.php');
    exit();
}

require_once('db.php');

// Get current month and year
$currentMonth = date('m');
$currentYear = date('Y');

if (isset($_POST['month'])) {
    // Get selected month and year
    $selectedMonth = $_POST['month'];
    $selectedYear = $_POST['year'];
} else {
    // Use current month and year if no selection made
    $selectedMonth = $currentMonth;
    $selectedYear = $currentYear;
}

// Get daily time records for selected month and year
$sql = "SELECT date, time_in, time_out FROM time_records WHERE user_id = ? AND MONTH(date) = ? AND YEAR(date) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $_SESSION['user_id'], $selectedMonth, $selectedYear);
$stmt->execute();
$result = $stmt->get_result();

// Calculate total hours and undertime
$totalHours = 0;
$workingDays = 0;
$undertime = 0;

while ($row = $result->fetch_assoc()) {
    $date = $row['date'];
    $timeIn = $row['time_in'];
    $timeOut = $row['time_out'];

    // Calculate total hours worked for the day
    if ($timeIn != null && $timeOut != null) {
        $totalHours += strtotime($timeOut) - strtotime($timeIn);
        $workingDays++;
    }

    // Check if undertime
    if ($timeIn != null && $timeOut != null) {
        $totalWorkingHours = strtotime('18:00') - strtotime('08:00');
        $workedHours = strtotime($timeOut) - strtotime($timeIn);
        if ($workedHours < $totalWorkingHours) {
            $undertime++;
        }
    }
}

// Format total hours to display as HH:MM
$totalHoursFormatted = sprintf('%02d:%02d', floor($totalHours / 3600), ($totalHours / 60) % 60);

// Get month and year options for dropdown
$sql = "SELECT DISTINCT MONTH(date) AS month, YEAR(date) AS year FROM time_records WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$monthOptions = '';
while ($row = $result->fetch_assoc()) {
    $month = $row['month'];
    $year = $row['year'];
    $selected = ($selectedMonth == $month && $selectedYear == $year) ? 'selected' : '';
    $monthOptions .= "<option value='$month-$year' $selected>" . date('F Y', strtotime("$year-$month-01")) . "</option>";
}

// Close database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Daily Time Records</title>
</head>
<body>
    <h1>Employee Daily Time Records</h1>

    <form method="post">
        <label for="month">Select month and year:</label>
        <select id="month" name="month">
            <?php echo $monthOptions; ?>
        </select>
        <button type="submit">Go</button
        </form>
        <?php
    // Get selected month and year
    $selectedMonth = $_POST['month'];
    $selectedYear = date('Y');

    // Check if month is selected
    if (!empty($selectedMonth)) {
        // Get time records for selected month and year
        $timeRecords = getTimeRecords($selectedMonth, $selectedYear, $employeeId);

        // Calculate total hours worked for the month
        $totalHours = 0;
        foreach ($timeRecords as $timeRecord) {
            $totalHours += $timeRecord['hours'];
        }

        // Check if undertime
        if ($totalHours < $minHours) {
            $undertime = true;
        } else {
            $undertime = false;
        }
?>

<h2><?php echo $selectedMonth . ' ' . $selectedYear; ?></h2>

<p>Total hours worked so far: <?php echo $totalHours; ?> hours</p>

<?php if ($undertime) { ?>
    <p style="color: red;">Undertime</p>
<?php } ?>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Hours</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($timeRecords as $timeRecord) { ?>
            <tr>
                <td><?php echo $timeRecord['date']; ?></td>
                <td><?php echo $timeRecord['time_in']; ?></td>
                <td><?php echo $timeRecord['time_out']; ?></td>
                <td><?php echo $timeRecord['hours']; ?></td>
                <td><?php echo $timeRecord['status']; ?></td>
                <td>
                    <form method="post" action="request-timerecord-change.php">
                        <input type="hidden" name="time_record_id" value="<?php echo $timeRecord['id']; ?>">
                        <button type="submit">Request Change</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php } else { ?>
    <p>Please select a month to view your daily time records.</p>
<?php } ?>
</body>
</html>