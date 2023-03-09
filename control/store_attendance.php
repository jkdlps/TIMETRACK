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
<?php
session_start();
include("connection.php");

if (isset($_POST['submit'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    echo $latitude;
    echo $_POST['user_id'];

    $sql = "INSERT INTO attendance (latitude,longitude) VALUES ('$latitude','$longitude') WHERE user_id=$user_id";
    echo $sql;

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Reserved Successfully";
        header("location: ../usersindex.php");
    } else {
        $_SESSION['message'] = "Wrong Password";
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Store Location</title>
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
    <h1>Store Location</h1>
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
    <form method="post">
        <input type="hidden" name="latitude" id="latitude" required>
        <input type="hidden" name="longitude" id="longitude" required>
        <button type="submit" name="submit">Store Location</button>
    </form>
</body>
</html>