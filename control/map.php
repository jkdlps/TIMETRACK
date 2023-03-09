<!DOCTYPE html>
<html>
<head>
	<title>Map Example</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.css" />
	<style>
		#mapid { height: 500px; }
	</style>
</head>
<body>

	<div id="mapid"></div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.min.js"></script>
	<script>
		var map = L.map('mapid').setView([14.871572599286143, 121.00173738453563], 10);
        // 14.871572599286143, 121.00173738453563

		L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
			maxZoom: 19
		}).addTo(map);

		L.marker([14.871572599286143, 121.00173738453563]).addTo(map)
			.bindPopup("<b>Municipal Office of Pulong Buhangin</b><br />Santa Maria, Bulacan.").openPopup();
	</script>

</body>
</html>
