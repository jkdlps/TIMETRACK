<!-- Display table of daily time record change requests -->
<table>
    <tr>
        <th>Employee Name</th>
        <th>Date</th>
        <th>Reason for Change</th>
        <th>Action</th>
    </tr>
    <?php
    $query = "SELECT dtr_change_requests.*, employees.name AS employee_name FROM dtr_change_requests JOIN employees ON dtr_change_requests.employee_id = employees.id";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>'.$row['employee_name'].'</td>';
        echo '<td>'.$row['date'].'</td>';
        echo '<td>'.$row['reason'].'</td>';
        echo '<td>';
        // Display a modal form to confirm the approval or denial of the request
        echo '<button onclick="openModal(\'approvalModal_'.$row['id'].'\')">Approve/Deny</button>';
        echo '<div id="approvalModal_'.$row['id'].'" class="modal">';
        echo '<div class="modal-content">';
        echo '<span class="close" onclick="closeModal()">&times;</span>';
        echo '<h2>DTR Change Request Approval</h2>';
        echo '<form method="post">';
        echo '<input type="hidden" name="request_id" value="'.$row['id'].'">';
        echo '<label for="approval">Approve or Deny?</label>';
        echo '<select name="approval" required>';
        echo '<option value="approve">Approve</option>';
        echo '<option value="deny">Deny</option>';
        echo '</select><br><br>';
        echo '<label for="comment">Comment:</label><br>';
        echo '<textarea name="comment" rows="4" cols="50" required></textarea><br><br>';
        echo '<button type="submit">Submit</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
    }
    ?>
</table>

<?php
// Handle the form submission to approve or deny the request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $approval = $_POST['approval'];
    $comment = $_POST['comment'];
    
    // Get the details of the request
    $query = "SELECT * FROM dtr_change_requests WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $request_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    if ($approval == 'approve') {
        // Redirect to the requested daily time record to change details
        header('Location: edit_dtr.php?id='.$row['dtr_id']);
        exit();
    } else {
        // Notify the employee and redirect to dashboard
        $to = $row['employee_email'];
        $subject = 'DTR Change Request Denied';
        $message = 'Your request to change your daily time record on '.$row['date'].' has been denied. Reason: '.$comment;
        $headers = 'From: employer@example.com';
        mail($to, $subject, $message, $headers);
        header('Location: dashboard.php');
        exit();
    }
}
?>
