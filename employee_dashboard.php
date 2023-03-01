<?php
session_start();
include "headers.php";

// Get attendance records for employee
$query = "SELECT * FROM attendances WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$attendances = $result->fetch_all(MYSQLI_ASSOC);

// Function to calculate distance between two sets of coordinates
function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  } else {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}
?>
	<h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
	
	<h2>Take Attendance</h2>
	<form method="post">
		<?php if (isset($success_message)) { echo "<p>$success_message</p>"; } ?>
		<input type="hidden" name="latitude" id="latitude">
		<input type="hidden" name="longitude" id="longitude">
		<button type="submit" name="take_attendance">Take Attendance</button>
	</form>
	
	<h2>Attendance Records</h2>
	<table>
		<thead>
			<tr>
				<th>Date</th>
				<th>Time In</th>
				<th>Time Out</th>
				<th>Location</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($attendances as $attendance): ?>
				<tr>
					<td><?php echo date('F j, Y', strtotime($attendance['timestamp'])); ?></td>
					<td><?php echo date('g:i A', strtotime($attendance['timestamp'])); ?></td>
					<td><?php echo ($attendance['timestamp_out'] ? date('g:i A', strtotime($attendance['timestamp_out'])) : ""); ?></td>
					<td><?php echo $attendance['location']; ?></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	
	<h2>Leave Credits</h2>
	<p>Remaining leave credits: <?php echo $remaining_leaves; ?></p>
	
	<script>
		// Get geolocation and fill in hidden form fields
		navigator.geolocation.getCurrentPosition(function(position) {
			document.getElementById("latitude").value = position.coords.latitude;
			document.getElementById("longitude").value = position.coords.longitude;
		});
	</script>
</body>
</html>
