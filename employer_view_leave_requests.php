<?php
// Initialize database connection
$conn = mysqli_connect("localhost", "username", "password", "database_name");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form has been submitted
if (isset($_POST['request_id']) && isset($_POST['status'])) {
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    $comment = $_POST['comment'];

    // Update the leave request status in the database
    $stmt = mysqli_prepare($conn, "UPDATE leave_requests SET status=?, comment=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $status, $comment, $request_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // If leave request is approved, add it to the employee's leave list
    if ($status == "approved") {
        $stmt = mysqli_prepare($conn, "INSERT INTO leaves (employee_id, start_date, end_date, reason) SELECT employee_id, start_date, end_date, reason FROM leave_requests WHERE id=?");
        mysqli_stmt_bind_param($stmt, "i", $request_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Redirect to dashboard
    header("Location: dashboard.php");
    exit();
}

// Get all leave requests from the database
$query = "SELECT lr.id, e.name, lr.start_date, lr.end_date, lr.reason, lr.status, lr.comment FROM leave_requests lr JOIN employees e ON lr.employee_id=e.id";
$result = mysqli_query($conn, $query);
?>

<!-- Display the leave requests in a table format -->
<h2>Leave Requests</h2>
<table>
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Comment</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['start_date']; ?></td>
            <td><?php echo $row['end_date']; ?></td>
            <td><?php echo $row['reason']; ?></td>
            <td><?php echo ucfirst($row['status']); ?></td>
            <td><?php echo $row['comment']; ?></td>
            <td>
                <?php if ($row['status'] == "pending") { ?>
                <!-- Display a modal form to confirm the approval or denial of the request -->
                <button onclick="openModal('approvalModal_<?php echo $row['id']; ?>')">Approve/Deny</button>
                <div id="approvalModal_<?php echo $row['id']; ?>" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h2>Approval Request</h2>
                        <form method="post">
                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                            <label for="status">Status:</label>
                            <select name="status" required>
                                <option value="approved">Approve</option>
                                <option value="denied">Denied</option>
                                </select><br><br>
                                <label for="reason">Reason/Comment:</label>
                                <textarea name="reason" rows="5" cols="40" placeholder="Enter reason/comment here"></textarea><br><br>
                                <button type="submit" name="submit">Submit</button>
                                <button type="button" onclick="closeModal()">Cancel</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
