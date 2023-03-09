<?php
session_start();
include "functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_SESSION['user_id'];
  $date = date('Y-m-d');
  $time = date('H:i:s');
  $latitude = $_POST['latitude'];
  $longitude = $_POST['longitude'];

db();

  $query = "INSERT INTO attendance (user_id, date, time, latitude, longitude) VALUES ('$user_id', '$date', '$time', '$latitude', '$longitude')";
  mysqli_query($con, $query);

  mysqli_close($con);
}
?>

<form method="post">
  <button type="button" onclick="getLocation()">Record Attendance</button>
</form>

<script>
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    alert('Geolocation is not supported by this browser.');
  }
}

function showPosition(position) {
  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById('attendance').innerHTML = this.responseText;
    }
  };
  xhttp.open('POST', 'record_attendance.php', true);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.send('latitude=' + latitude + '&longitude=' + longitude);
}
</script>
