<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/leaflet/1.0.0-beta.2/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/leaflet/1.0.0-beta.2/leaflet.js"></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Attendance</h1>
    <div id="map"></div>
    <script>
        var map = L.map('map').setView([0, 0], 1);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
            maxZoom: 18,
            id: 'osm.streets'
        }).addTo(map);
        map.locate({setView: true, maxZoom: 16});
        function onLocationFound(e) {
            var radius = e.accuracy / 2;
            L.marker(e.latlng).addTo(map)
                .bindPopup("You are within " + radius.toFixed(2) + " meters of this point.").openPopup();
            L.circle(e.latlng, radius).addTo(map);
            var latitude = e.latlng.lat.toFixed(6);
            var longitude = e.latlng.lng.toFixed(6);
            document.getElementById("latitude").value = latitude;
            document.getElementById("longitude").value = longitude;
        }
        map.on('locationfound', onLocationFound);
    </script>

    <form method="post" action="../backend/attendancebackend.php">
        <input type="hidden" name="latitude" id="latitude" required>
        <input type="hidden" name="longitude" id="longitude" required>
        <button type="submit" name="submit">Store Location</button>
    </form>
</body>
</html>