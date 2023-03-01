<?php
// Include database connection
include 'db_connect.php';

// Get list of employees for combobox
$employee_list = array();
$sql = "SELECT id, name FROM employees";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $employee_list[$row['id']] = $row['name'];
}

// Handle form submission
if (isset($_POST['employee_id'])) {
    $employee_id = $_POST['employee_id'];
    
    // Get daily time records for selected employee
    $dtr_list = array();
    $total_hours = 0;
    $sql = "SELECT id, employee_id, time_in, time_out, DATE(time_in) AS date, SEC_TO_TIME(TIMESTAMPDIFF(SECOND, time_in, time_out)) AS hours FROM daily_time_records WHERE employee_id = ? ORDER BY time_in DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $dtr_list[] = $row;
        if ($row['time_out'] != null) {
            $total_hours += strtotime($row['hours']) - strtotime('00:00:00');
        }
    }
}
?>

<!-- Display the page content -->
<h1>View Daily Time Records</h1>

<form method="post">
    <label for="employee_id">Select Employee:</label>
    <select name="employee_id" id="employee_id">
        <?php foreach ($employee_list as $id => $name) { ?>
            <option value="<?php echo $id; ?>"><?php echo $name; ?></option>
        <?php } ?>
    </select>
    <button type="submit">View DTR</button>
</form>

<?php if (isset($_POST['employee_id'])) { ?>
    <h2><?php echo $employee_list[$employee_id]; ?>'s Daily Time Records</h2>
    
    <p>Total Hours: <?php echo gmdate('H:i:s', $total_hours); ?></p>
    
    <table>
        <tr>
            <th>Date</th>
            <th>Time In</th>
            <th>Time Out</th>
            <th>Hours</th>
            <th>Edit</th>
        </tr>
        <?php foreach ($dtr_list as $dtr) { ?>
            <tr>
                <td><?php echo $dtr['date']; ?></td>
                <td><?php echo $dtr['time_in']; ?></td>
                <td><?php echo $dtr['time_out'] ?? '-'; ?></td>
                <td><?php echo $dtr['hours'] ?? '-'; ?></td>
                <td><button onclick="location.href='edit_dtr.php?id=<?php echo $dtr['id']; ?>'">Edit</button></td>
            </tr>
        <?php } ?>
    </table>
    
    <button onclick="window.print()">Print</button>
<?php } ?>
