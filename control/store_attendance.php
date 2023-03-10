<!DOCTYPE html>
<html>
<head>
    <title>Attendance | Timetrack</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/leaflet/1.0.0-beta.2/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/leaflet/1.0.0-beta.2/leaflet.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body onload="getLocation();">
    <h1>Attendance | Timetrack</h1>
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

<div class="container col-xl-10 col-xxl-8 px-4 py-5" id='body'>
    <div class="row align-items-center g-lg-5 ">

    <div class="col-md-10 mx-auto col-lg-12">

        <form class="myForm p-4 p-md-5 card mx-2" action="../backend/attendancebackend.php" method="POST"
            enctype="multipart/form-data">

    <h1>Time In</h1>
    <div class='row'>
        <div class='col-lg-6'>
    </div>
    <div class='row'>
        <div class='col-lg-6'>
            <!-- Time  -->
            <div class="form-outline mb-4">
                <label class="form-label" for="time">Time</label>
                <h3 id="clock"></h3>
                <script>
                function updateTime() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();

        // Add leading zeros to the hours, minutes, and seconds
        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        // Format the time as "hh:mm:ss"
        var timeString = hours + ":" + minutes + ":" + seconds;

        // Update the clock element with the new time
        document.getElementById("clock").innerHTML = timeString;
    }

    // Call updateTime every second to update the clock
    setInterval(updateTime, 1000);
    </script>
            </div>
        </div>
        <div class='col-lg-6'>
            <!-- Date -->
            <div class="form-outline mb-4">
                <label class="form-label" for="date">Date</label>
                <h3>
                    <?php
                        date_default_timezone_set('Asia/Manila');
                        $date = date('l, F d, Y');
                        echo $date;
                        ?>
                </h3>
            </div>
        </div>


    <form method="post" action="../backend/attendancebackend.php">
        <input type="text" name="latitude" id="latitude">
        <input type="text" name="longitude" id="longitude">
        <button class="w-100 btn btn-lg btn-outline-dark mt-3" type="submit" name='submit' value="submit">Time In</button>
<a href="../index.php" class="w-100 btn btn-lg btn-outline-dark mt-3">Log Out</a>
    </form>
</body>
</html>