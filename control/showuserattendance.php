<?php
session_start();
include "connection.php";
include "../backend/message.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendances</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</head>

<body>
    <h1 class='text-center mt-5'>Attendance</h1>
    <!--Table-->

    <div class="container pt-4" id='body'>
        <button onclick="window.print();" class="btn btn-primary">Print Attendance Table</button>
        <a href="store_attendance.php" class="btn btn-secondary">Back to Attendance Page</a>
        <div class="table-responsive text-center">
            <table class="table table-bordered bg-white " id="datatable">
                <thead class="bg-primary text-light">
                    <tr>
                        <th>Attendance ID</th>
                        <th>Employee ID</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $employee_id = $_SESSION['id'];

                    $sql = "SELECT * FROM attendances WHERE employee_id='$employee_id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            //table & Modal Buttons
                            //Button trigger modal || id=#updatemodal  
                            echo "<tr>
        <td>" . $row['id'] . "</td>
        <td>" . $row['employee_id'] . "</td>
        <td>" . $row['latitude'] . "</td>
        <td>" . $row['longitude'] . "</td>
        <td>" . $row['location'] . "</td>
        <td>" . $row['date'] . "</td>
        <td>" . $row['timein'] . "</td>
        <td>" . $row['timeout'] . "</td>
    </td>
    </tr>";
                        }
                    } else {
                        $_SESSION['message'] = "No results found.";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--End of Table-->
</body>

</html>