<?php
// check if the form is submitted
if(isset($_POST['submit'])) {
    // get the request id and approval status from the form data
    $requestId = $_POST['request_id'];
    $approvalStatus = $_POST['approval_status'];
    $comment = $_POST['comment'];

    // update the account request with the approval status and comment
    $stmt = $conn->prepare("UPDATE account_requests SET approval_status = ?, comment = ? WHERE id = ?");
    $stmt->bind_param("ssi", $approvalStatus, $comment, $requestId);
    $stmt->execute();

    // if the request is approved, add the user as an employee
    if($approvalStatus == 'approved') {
        $stmt = $conn->prepare("INSERT INTO employees (name, email) SELECT name, email FROM account_requests WHERE id = ?");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
    }
    // if the request is denied, notify the user by email
    else if($approvalStatus == 'denied') {
        $stmt = $conn->prepare("SELECT name, email FROM account_requests WHERE id = ?");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $to = $row['email'];
        $subject = "Account Request Denied";
        $message = "Dear " . $row['name'] . ",\n\nYour account request has been denied. Reason: " . $comment . "\n\nBest regards,\nEmployer";
        $headers = "From: employer@example.com";
        mail($to, $subject, $message, $headers);
    }

    // redirect back to the account requests page
    header("Location: account_requests.php");
    exit();
}

// get the account requests from the database
$stmt = $conn->prepare("SELECT * FROM account_requests");
$stmt->execute();
$result = $stmt->get_result();

?>

<!-- Display the account requests in a table -->
<h1>Account Requests</h1>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Date Requested</th>
            <th>Approval Status</th>
            <th>Comment</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['date_requested']; ?></td>
                <td><?php echo $row['approval_status']; ?></td>
                <td><?php echo $row['comment']; ?></td>
                <td>
                    <!-- Display a modal form to confirm the approval or denial of the request -->
                    <button onclick="openModal('approvalModal_<?php echo $row['id']; ?>')">Approve/Deny</button>
                    <div id="approvalModal_<?php echo $row['id']; ?>" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <h2>Approval Request</h2>
                            <form method="post">
                                <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                <label for="
                                <label for="approval">Approve or Deny?</label>
                                <select id="approval" name="approval">
                                    <option value="approve">Approve</option>
                                    <option value="deny">Deny</option>
                                </select>
                                <label for="reason">Reason/Comment:</label>
                                <textarea id="reason" name="reason"></textarea>
                                <button type="submit">Submit</button>
                                <button type="button" onclick="closeModal()">Cancel</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No account requests found.</p>
<?php endif; ?>

<?php
// Process the approval/denial of account requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id']) && isset($_POST['approval']) && isset($_POST['reason'])) {
    $requestId = $_POST['request_id'];
    $approval = $_POST['approval'];
    $reason = $_POST['reason'];

    // Update the status of the request in the database
    $stmt = $pdo->prepare("UPDATE account_requests SET status = :status, reason = :reason WHERE id = :id");
    $stmt->execute(array(':status' => $approval, ':reason' => $reason, ':id' => $requestId));

    if ($approval === 'approve') {
        // Add the user as an employee
        $user = getUserById($pdo, $requestId);
        $stmt = $pdo->prepare("INSERT INTO employees (name, email) VALUES (:name, :email)");
        $stmt->execute(array(':name' => $user['name'], ':email' => $user['email']));
    } else {
        // Notify the user by email that their request has been denied
        $user = getUserById($pdo, $requestId);
        $to = $user['email'];
        $subject = 'Account Request Denied';
        $message = 'Your account request has been denied due to the following reason: ' . $reason;
        $headers = 'From: example@example.com';
        mail($to, $subject, $message, $headers);

        // Redirect to the dashboard
        header('Location: dashboard.php');
        exit();
    }
}
?>
