<!-- Button to open modal form -->
<button id="requestLeaveBtn">Request Leave</button>

<!-- Modal form -->
<div id="requestLeaveModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Request Leave</h2>
    <form method="post" action="employee-request-leave.php">
      <label for="startDate">Start Date:</label>
      <input type="date" id="startDate" name="startDate" required>
      <br><br>
      <label for="endDate">End Date:</label>
      <input type="date" id="endDate" name="endDate" required>
      <br><br>
      <label for="reason">Reason:</label>
      <textarea id="reason" name="reason" required></textarea>
      <br><br>
      <button type="submit">Submit Request</button>
    </form>
  </div>
</div>

<!-- JavaScript to open and close modal form -->
<script>
  var modal = document.getElementById("requestLeaveModal");
  var btn = document.getElementById("requestLeaveBtn");
  var span = document.getElementsByClassName("close")[0];

  btn.onclick = function() {
    modal.style.display = "block";
  }

  span.onclick = function() {
    modal.style.display = "none";
  }

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>

<?php
// Start the session and connect to the database
session_start();
include 'db-connect.php';

// Check if the user is logged in and is an employee
if (!isset($_SESSION['userID']) || $_SESSION['userRole'] != 0) {
  header('Location: login.php');
  exit();
}

// Get the form data
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$reason = $_POST['reason'];
$employeeID = $_SESSION['userID'];
$status = 0; // Leave request status 0 = pending, 1 = approved, 2 = denied

// Prepare the SQL statement to insert the leave request into the database
$stmt = $conn->prepare("INSERT INTO leaves (employeeID, startDate, endDate, reason, status) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isssi", $employeeID, $startDate, $endDate, $reason, $status);
$stmt->execute();

// Close the prepared statement and database connection
$stmt->close();
$conn->close();

// Redirect back to the employee dashboard
header('Location: employee-dashboard.php');
exit();
?>
