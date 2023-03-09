<?php
session_start();
include "conn.php";
include "header.php";
?>

<div>
    <h2>Approve Leave Request</h2>
</div>

<?php
// Get leave request ID from URL parameter
$id = $_GET['id'];

// Query to get leave request details
$sql = "SELECT * FROM leave_requests WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $comment = $_POST['comment'];

    // Update leave request status and comment
    $sql = "UPDATE leave_requests SET status = '$status', comment = '$comment' WHERE id = $id";
    mysqli_query($conn, $sql);

    // If leave request is approved, add to leave list
    if ($status == 'Approved') {
        $employee_name = $row['employee_name'];
        $leave_start_date = $row['leave_start_date'];
        $leave_end_date = $row['leave_end_date'];
        $reason_for_leave = $row['reason_for_leave'];

        $sql = "INSERT INTO leave_list (employee_name, leave_start_date, leave_end_date, reason_for_leave) VALUES ('$employee_name', '$leave_start_date', '$leave_end_date', '$reason_for_leave')";
        mysqli_query($conn, $sql);
    }

    // Notify employee if leave request is denied
    if ($status == 'Denied') {
        $employee_email = $row['employee_email'];
        $subject = "Leave Request Denied";
        $message = "Your leave request from ".$row['leave_start_date']." to ".$row['leave_end_date']." has been denied. Reason: ".$comment;
        mail($employee_email, $subject, $message);
    }

    // Redirect to dashboard
    header('Location: dashboard.php');
    exit();
}

// Display leave request details and form for approval
echo "<p>Employee: ".$row['employee_name']."</p>";
echo "<p>Leave Start Date: ".$row['leave_start_date']."</p>";
echo "<p>Leave End Date: ".$row['leave_end_date']."</p>";
echo "<p>Reason for Leave: ".$row['reason']."</p>";
echo "<form method='post' action=''>";
echo "<input type='hidden' name='request_id' value='".$row['id']."'>";
echo "<label for='status'>Status:</label>";
echo "<select name='status' id='status'>";
echo "<option value='approved'>Approved</option>";
echo "<option value='denied'>Denied</option>";
echo "</select>";
echo "<br>";
echo "<label for='comment'>Reason/Comment:</label>";
echo "<textarea name='comment' id='comment' rows='4' cols='50'></textarea>";
echo "<br>";
echo "<input type='submit' name='submit' value='Submit'>";
echo "</form>";

// Process form submission
if (isset($_POST['submit'])) {
$request_id = $_POST['request_id'];
$status = $_POST['status'];
$comment = $_POST['comment'];

// Update leave request status and comment in database
$sql = "UPDATE leave_requests SET status=?, comment=? WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssi", $status, $comment, $request_id);
mysqli_stmt_execute($stmt);

// If approved, add leave to leave list
if ($status == "approved") {
$sql = "INSERT INTO leave_list (employee_id, leave_start_date, leave_end_date, reason) SELECT employee_id, leave_start_date, leave_end_date, reason FROM leave_requests WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $request_id);
mysqli_stmt_execute($stmt);
}

// Redirect to dashboard
header("Location: dashboard.php");
exit();
}
?>

<div>
    <form action='employer_dashboard.php' method='post'>
        <button type='submit'>Back to Dashboard</button>
    </form>
</div>