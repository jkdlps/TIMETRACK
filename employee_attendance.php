<?php
include "header.php";
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
    <h2>Employee Attendance</h2>
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