<?php
session_start();
include "control/functions.php";
db();

// $rows = mysqli_query($con, "SELECT * FROM attendance");
// $i = 1;

// foreach($rows as $row) :
?>
<?php 
// endforeach;

include "control/follow_user.php";

head("Attendance");
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

                        <form class="myForm p-4 p-md-5 card mx-2" action="./backend/insertAttendance.php" method="POST"
                            enctype="multipart/form-data">


                            <h1>Time In</h1>
                            <div class='row'>
                                <div class='col-lg-6'>
                                    <!-- Lat  -->
                                    <!-- <div class="form-outline mb-4">
                                        <label class="form-label" for="latitude">Latitude: </label>
                                        <input type="text" name="latitude" id="latitude"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class='col-lg-6'> -->
                                    <!-- Long -->
                                    <!-- <div class="form-outline mb-4">
                                        <label class="form-label" for="longitude">Longitude: </label>
                                        <input type="text" name="longitude" id="longitude"
                                            class="form-control" />
                                    </div>
                                </div> -->

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
                                                $time = date('Y-m-d');
                                                echo $time;
                                                ?>
                                        </h3>
                                    </div>
                                </div>
<!-- 
                                <div class="mapouter card">
                                    <div class="gmap_canvas">
                                        <iframe width="480" height="481" id="gmap_canvas"
                                            src="https://maps.google.com/maps?q= <?php 
                                            // echo $row['latitude']; ?>,
                                            <?php 
                                            // echo $row['longitude']; 
                                            ?>&hl=es;z=14&output=embed"
                                            frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                        <style>
                                        .mapouter {
                                            position: relative;
                                            text-align: right;
                                            height: 481px;
                                            width: 481px;
                                        }
                                        </style><a href="https://www.embedgooglemap.net">embedgooglemap.net</a>
                                        <style>
                                        .gmap_canvas {
                                            overflow: hidden;
                                            background: none !important;
                                            height: 481px;
                                            width: 479px;
                                        }
                                        </style>
                                    </div>
                                </div> -->

                            </div>


                            <!-- Timein button -->

                            <button class="w-100 btn btn-lg btn-outline-dark mt-3" type="submit" name='submit' value="signup">Time In</button>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>