<?php
// Check if form is submitted
if(isset($_POST['submit'])){
    // Get form data
    $request_id = $_POST['request_id'];
    $status = $_POST['status'];
    $comment = $_POST['comment'];

    // Prepare SQL statement
    $stmt = $conn->prepare("UPDATE leave_requests SET status=?, comment=? WHERE id=?");
    $stmt->bind_param("ssi", $status, $comment, $request_id);
    
    // Execute SQL statement
    if($stmt->execute()){
        if($status == "approved"){
            // Automatically add leave to leave list
            $request = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM leave_requests WHERE id=$request_id"));
            $employee_id = $request['employee_id'];
            $leave_start_date = $request['leave_start_date'];
            $leave_end_date = $request['leave_end_date'];
            $reason = $request['reason'];
            mysqli_query($conn, "INSERT INTO leaves (employee_id, leave_start_date, leave_end_date, reason) VALUES ('$employee_id', '$leave_start_date', '$leave_end_date', '$reason')");

            echo "<script>alert('Leave request approved.')</script>";
        } else {
            // Notify employee of denial and redirect to dashboard
            $request = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM leave_requests WHERE id=$request_id"));
            $employee_id = $request['employee_id'];
            $employee_email = mysqli_fetch_assoc(mysqli_query($conn, "SELECT email FROM employees WHERE id=$employee_id"))['email'];
            $to = $employee_email;
            $subject = "Leave Request Denied";
            $message = "Your leave request from ".$request['leave_start_date']." to ".$request['leave_end_date']." has been denied. Reason: ".$comment;
            $headers = "From: Your Company <noreply@yourcompany.com>";
            mail($to, $subject, $message, $headers);
            
            echo "<script>alert('Leave request denied.')</script>";
        }
    } else {
        echo "<script>alert('Error approving/denying leave request.')</script>";
    }
}
?>

<!-- Display leave requests in a table format -->
<table>
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Leave Start Date</th>
            <th>Leave End Date</th>
            <th>Reason</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Retrieve leave requests from database
        $query = "SELECT lr.id, e.name, lr.leave_start_date, lr.leave_end_date, lr.reason FROM leave_requests lr JOIN employees e ON lr.employee_id = e.id WHERE lr.status='pending'";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>'.$row['name'].'</td>';
            echo '<td>'.$row['leave_start_date'].'</td>';
            echo '<td>'.$row['leave_end_date'].'</td>';
            echo '<td>'.$row['reason'].'</td>';
            echo '<td>';
            echo '<button onclick="openModal(\'approvalModal_'.$row['id'].'\')">Approve/Deny</button>';
            echo '<div id="approvalModal_'.$row['id'].'" class="modal">';
            echo '<div class="modal-content">';
            echo '<span class="close" onclick="closeModal()">&times;</span>';
            echo '<h2>Approval Request
</h2>
            <form method="post">
                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                <label for="status">Status:</label>
                <select name="status" required>
                    <option value="approved">Approve</option>
                    <option value="denied">Deny</option>
                </select><br><br>
                <label for="comment">Comment:</label>
                <textarea name="comment"></textarea><br><br>
                <button type="submit" name="submit">Submit</button>
            </form>
        </div>
    </div>
    </td>';
echo '</tr>';
}
echo '</table>';
    // Handle form submission
    if (isset($_POST['submit'])) {
        $request_id = $_POST['request_id'];
        $status = $_POST['status'];
        $comment = $_POST['comment'];

        // Update leave request status in database
        $query = "UPDATE leave_requests SET status=?, comment=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssi', $status, $comment, $request_id);
        mysqli_stmt_execute($stmt);

        // If approved, add leave to list
        if ($status == 'approved') {
            $query = "SELECT employee_id, leave_start_date, leave_end_date FROM leave_requests WHERE id=?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'i', $request_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            $employee_id = $row['employee_id'];
            $leave_start_date = $row['leave_start_date'];
            $leave_end_date = $row['leave_end_date'];

            $query = "INSERT INTO leaves (employee_id, leave_start_date, leave_end_date) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'iss', $employee_id, $leave_start_date, $leave_end_date);
            mysqli_stmt_execute($stmt);
        }

        // Notify employee and redirect to dashboard
        $employee_id = $_SESSION['user_id'];
        $query = "SELECT email FROM employees WHERE id=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $employee_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $employee_email = $row['email'];

        $subject = 'Leave Request Status Update';
        $message = 'Your leave request has been '.$status.' with the following comment: '.$comment;
        $headers = 'From: company@example.com';

        mail($employee_email, $subject, $message, $headers);

        header('Location: dashboard.php');
        exit();
    }
}
?>
