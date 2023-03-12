<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Attendance</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
	<!-- Make sure you put this AFTER Leaflet's CSS -->
	<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
	<style>
		#map {
			height: 500px;
			width: 100%;
		}
	</style>
</head>

<body>

	<div id="map"></div>

	<script>
		var map = L.map('map').setView([0, 0], 15);

		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
			maxZoom: 18,
			id: 'osm.streets'
		}).addTo(map);

		// Add a marker at the user's geolocation
		map.locate({
			setView: true,
			maxZoom: 15
		});

		// Define the geofence as a circle on the map
		var geofence = L.circle([14.871546, 121.001179], {
			color: 'green',
			fillColor: 'green',
			fillOpacity: 0.2,
			radius: 30
		}).addTo(map);

		function onLocationFound(e) {
			var marker = L.marker(e.latlng).addTo(map);
			marker.bindPopup("You are here!").openPopup();

			// Store the geolocation in the database
			var latitude = e.latlng.lat;
			var longitude = e.latlng.lng;
			document.getElementById("latitude").value = latitude;
			document.getElementById("longitude").value = longitude;
		}
		map.on('locationfound', onLocationFound);

		// Handle errors when trying to get the user's geolocation
		function onLocationError(e) {
			alert(e.message);
		}
		map.on('locationerror', onLocationError);
	</script>
<!-- 
	<form method="post" action="../backend/attendancebackend.php">
		<label for="latitude" class="form-label">Latitude: </label>
		<input type="text" class="form-control" name="latitude" id="latitude" disabled>
		<label for="longitude" class="form-label">Longitude: </label>
		<input type="text" class="form-control" name="longitude" id="longitude" disabled>
		<button class="w-100 btn btn-lg btn-outline-dark mt-3" type="submit" name='submit' value="submit">Time In</button>
	</form>
	<div>
		<form action="timeout.php" method="post">
			<button class="w-100 btn btn-lg btn-outline-dark mt-3" type="submit" name='submit' value="submit">Time Out</button>
		</form>
		<a href="../index.php" class="w-100 btn btn-lg btn-outline-dark mt-3">Log Out</a>
	</div>

</body> -->

</html>