<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Leaflet Map Example</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/leaflet/1.3.1/leaflet.css" />
	<script src="https://cdn.jsdelivr.net/leaflet/1.3.1/leaflet.js"></script>
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
		maxZoom: 19,
	}).addTo(map);

	// Add a marker at the user's geolocation
	map.locate({setView: true, maxZoom: 15});
	function onLocationFound(e) {
	    var marker = L.marker(e.latlng).addTo(map);
		marker.bindPopup("You are here!").openPopup();
		
		// Store the geolocation in the database
		var latitude = e.latlng.lat;
		var longitude = e.latlng.lng;
		storeLocation(latitude, longitude);
	}
	map.on('locationfound', onLocationFound);

	// Handle errors when trying to get the user's geolocation
	function onLocationError(e) {
		alert(e.message);
	}
	map.on('locationerror', onLocationError);

	// Store the geolocation in the database using AJAX
	function storeLocation(latitude, longitude) {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				console.log(this.responseText);
			}
		};
		xmlhttp.open("POST", "store_location.php", true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("latitude=" + latitude + "&longitude=" + longitude);
	}

</script>

</body>
</html>
