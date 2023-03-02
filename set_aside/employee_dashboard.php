<?php
// Start session and check if user is logged in as employee
// session_start();
// if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 0) {
//   header('Location: login.php');
//   exit();
// }

// Connect to database
include "../header.php";

// Get employee's daily time record for this month
$user_id = $_SESSION['user_id'];
$month_start = date('Y-m-01');
$month_end = date('Y-m-t');
$stmt = $pdo->prepare("SELECT * FROM time_records WHERE user_id = ? AND date BETWEEN ? AND ?");
$stmt->execute([$user_id, $month_start, $month_end]);
$time_records = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get employee's attendance status for today
$today = date('Y-m-d');
$stmt = $pdo->prepare("SELECT * FROM time_records WHERE user_id = ? AND date = ?");
$stmt->execute([$user_id, $today]);
$attendance = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if employee has taken attendance for today
$attended_today = false;
if ($attendance && $attendance['time_out'] != null) {
  $attended_today = true;
}

// Display employee dashboard
?>
<h1>Employee Dashboard</h1>
<h2>Daily Time Record for <?php echo date('F Y'); ?></h2>
<table>
  <thead>
    <tr>
      <th>Date</th>
      <th>Time In</th>
      <th>Time Out</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($time_records as $record): ?>
      <tr>
        <td><?php echo $record['date']; ?></td>
        <td><?php echo $record['time_in']; ?></td>
        <td><?php echo $record['time_out']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<h2>Attendance Status for Today</h2>
<?php if ($attended_today): ?>
  <p>You have timed out for today.</p>
<?php elseif ($attendance): ?>
  <p>You have timed in for today.</p>
  <form method="post" action="take_attendance.php">
    <input type="hidden" name="attendance_id" value="<?php echo $attendance['id']; ?>">
    <button type="submit">Time Out</button>
  </form>
<?php else: ?>
  <p>You have not yet taken attendance for today.</p>
  <form method="post" action="take_attendance.php">
    <button type="submit">Time In</button>
  </form>
<?php endif; ?>
<h2>Leave History</h2>
<a href="leave_history.php">View Leave History</a>

<h1>Employee Leaves</h1>

<p>Remaining Leave Credit: <?php echo $remainingLeaveCredit; ?></p>

<table>
  <tr>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Reason</
    </table>
<button id="requestLeaveBtn">Request Leave</button>

<!-- Request Leave Modal -->
<div id="requestLeaveModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Request Leave</h2>
    <form method="post">
      <label for="leaveStartDate">Start Date:</label>
      <input type="date" id="leaveStartDate" name="leaveStartDate"><br><br>
      <label for="leaveEndDate">End Date:</label>
      <input type="date" id="leaveEndDate" name="leaveEndDate"><br><br>
      <label for="leaveReason">Reason:</label>
      <textarea id="leaveReason" name="leaveReason"></textarea><br><br>
      <button type="submit">Submit</button>
    </form>
  </div>
</div>
<script>
// Get the modal
var modal = document.getElementById("requestLeaveModal");

// Get the button that opens the modal
var btn = document.getElementById("requestLeaveBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>