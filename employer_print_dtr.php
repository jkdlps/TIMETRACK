<?php
require('fpdf/fpdf.php');

if (isset($_POST['print'])) {
    // Get input data
    $employee_name = $_POST['employee_name'];
    $month = $_POST['month'];
    $total_hours = $_POST['total_hours'];

    // Generate PDF file
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set font and write employee name and month
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Daily Time Record - '.$employee_name.' - '.$month, 0, 1, 'C');

    // Set font and write table headers
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'Date', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Time In', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Time Out', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Total Hours', 1, 1, 'C');

    // Set font and write table data
    $pdf->SetFont('Arial', '', 12);
    $query = "SELECT * FROM daily_time_records WHERE employee_name = ? AND month = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $employee_name, $month);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row['date'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['time_in'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['time_out'], 1, 0, 'C');
        $pdf->Cell(30, 10, $row['total_hours'], 1, 1, 'C');
    }

    // Set font and write total hours
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(120, 10, 'Total Hours:', 0, 0, 'R');
    $pdf->Cell(30, 10, $total_hours, 0, 1, 'C');

    // Output PDF file
    $pdf->Output();
}
?>

<!-- Print Daily Time Record Modal Form -->
<div id="printDtrModal" style="display: none;">
    <h2>Print Daily Time Record</h2>
    <form method="post" action="generate_pdf.php" target="_blank">
        <label for="employee_name">Employee Name:</label>
        <select name="employee_name" required>
            <?php
            $query = "SELECT name FROM employees";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
            }
            ?>
        </select><br><br>
        <label for="month">Month:</label>
        <select name="month" required>
            <option value="January">January</option>
            <option value="February">February</option>
            <option value="March">March</option>
            <option value="April">April</option>
            <option value="May">May</option>
            <option value="June">June</option>
            <option value="July">July</option>
            <option value="August">August</option>
            <option value="September">September</option>
            <option value="October">October</option>
            <option value="November">November</option>
            <option value="December">December</option>
        </select><br><br>
        <label for="total_hours">Total Hours:</label>
        <input type="number" name="total_hours" required><br><br>
        <button type="submit">Generate PDF</button>
        <button type="button" onclick="closeModal()">Cancel</button>
    </form>
</div>

