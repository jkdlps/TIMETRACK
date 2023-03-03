<?php
session_start();
include "conn.php";
include "header.php";

// Get the form data
$date = $_POST['date'];
$time = $_POST['time'];
$location = $_POST['location'];
$in_office = $_POST['in_office'];
$user_id = $_SESSION['user_id'];

// Convert the time to Asia/Manila timezone
$datetime = new DateTime($date . ' ' . $time, new DateTimeZone('UTC'));
$datetime->setTimezone(new DateTimeZone('Asia/Manila'));
$timestamp = $datetime->format('Y-m-d H:i:s');

// Check if the user has already timed in
$sql = "SELECT * FROM attendance WHERE user_id='$user_id' AND time_out IS NULL";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
// User has already timed in, update the time_out column
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$sql = "UPDATE attendance SET time_out='$timestamp' WHERE id='$id'";
mysqli_query($conn, $sql);
} else {
// User has not timed in yet, insert a new record
$sql = "INSERT INTO attendance (user_id, time_in, location, in_office) VALUES ('$user_id', '$timestamp', '$location', '$in_office')";
mysqli_query($conn, $sql);
}

mysqli_close($conn);

// Redirect to the dashboard
header("Location: employee_dashboard.php");
exit();
?>

?>
    <script>
    function getLocation() {
        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
        } else {
        alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        // Get the latitude and longitude
        var lat = position.coords.latitude;
        var lon = position.coords.longitude;

        // Check if the location is within the geofence
        if (lat > 14.795208 && lat < 14.799445 && lon > 121.070042 && lon < 121.073590) {
        document.getElementById("location").value = lat + "," + lon;
        document.getElementById("status").innerHTML = "In office";
        document.getElementById("in_office").value = "1";
        } else {
        document.getElementById("location").value = lat + "," + lon;
        document.getElementById("status").innerHTML = "Work from home";
        document.getElementById("in_office").value = "0";
        }
    }
    </script>
</head>
<body>
    <h1>Employee Attendance</h1>
    <form method="post" action="submit_attendance.php">
    <label>Date:</label>
    <input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" required>
    <br>
    <label>Time:</label>
    <input type="time" name="time" value="<?php echo date('H:i'); ?>" required>
    <br>
    <label>Location:</label>
    <input type="text" name="location" id="location" readonly>
    <button type="button" onclick="getLocation()">Get Location</button>
    <br>
    <label>Status:</label>
    <span id="status"></span>
    <input type="hidden" name="in_office" id="in_office" value="">
    <br>
    <input type="submit" value="Submit">
    </form>
</body>
</html>