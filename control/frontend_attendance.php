<?php
// Start the session
// session_start();

// Check if the user is logged in
// if (!isset($_SESSION['email'])) {
//     header("Location: ../loginpage.php");
//     exit();
// }

// // Check if it's a POST request
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
//     // Get the user's location from the POST data
//     $latitude = $_POST['latitude'];
//     $longitude = $_POST['longitude'];
    
//     // Get the user's email from the session
//     $email = $_SESSION['email'];
    
//     // Insert the location record into the database
//     include "functions.php";
//     db();
//     $stmt = mysqli_prepare($con, "INSERT INTO attendance (latitude, longitude) VALUES (?, ?, ?) WHERE email = $email");
//     mysqli_stmt_bind_param($stmt, 'dd', $latitude, $longitude);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_close($stmt);
//     mysqli_close($con);
    


//     // Redirect the user to the map page
//     header("Location: ../usersindex.php");
//     exit();
// }
?>

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
</body>
</html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance | Timetrack</title>

<?php 
// endforeach;

include "control/follow_user.php";
?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
                crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
                integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
                crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
                integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
                crossorigin="anonymous">
            </script>
        </head>

        <body onload="getLocation();">

            <div class="container col-xl-10 col-xxl-8 px-4 py-5" id='body'>
                <div class="row align-items-center g-lg-5 ">

                    <div class="col-md-10 mx-auto col-lg-12">

                        <form class="myForm p-4 p-md-5 card mx-2" action="frontend_attendance.php" method="POST"
                            enctype="multipart/form-data">

                            </div>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <!-- Time  -->
                                    <div class="form-outline mb-4">
                                        <label class="form-label" for="time">Time</label>
                                        <h3 id="clock"></h3>
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
                            </div>

                            <!-- Timein button -->
                            <form method="post" action="../backend/attendancebackend.php">
        <input type="hidden" name="latitude" id="latitude" required>
        <input type="hidden" name="longitude" id="longitude" required>
        <button class="w-100 btn btn-lg btn-outline-dark mt-3" type="submit" name='submit' value="signup">Time In</button>
    </form>
                            <a href="index.php" class="w-100 btn btn-lg btn-outline-dark mt-3">Back to Homepage</a>
                        </form>
                    </div>
                    
                </div>
            </div>


        </body>

        </html>
    </div>

    <script type="text/javascript">
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        }
    }

    function showPosition(position) {
        document.querySelector('.myForm input[name = "latitude"]').value = position.coords.latitude;
        document.querySelector('.myForm input[name = "longitude"]').value = position.coords.longitude;
    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("Geolocation must be allowed");
                location.reload();
                break;
        }
    }

function updateTime() {
  var now = new Date();
  var hours = now.getHours() % 12 || 12; // convert to 12-hour format
  var minutes = now.getMinutes();
  var seconds = now.getSeconds();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12; // convert to 12-hour format
  hours = hours < 10 ? '0' + hours : hours;
  minutes = minutes < 10 ? '0' + minutes : minutes;
  seconds = seconds < 10 ? '0' + seconds : seconds;
  var timeString = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
  document.getElementById('clock').innerHTML = timeString;
}
setInterval(updateTime, 1000);
</script>
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>