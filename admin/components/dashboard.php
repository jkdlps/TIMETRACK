<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container" id='body'>

        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active"></li>
                </ol>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-dark text-white mb-4">
                            <div class="card-body">Employees</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <?php
                                include "../TIMETRACK/control/connection.php";
                                // COUNT By ID
                                $sql = "SELECT id FROM users ORDER BY id";
                                $query_run = mysqli_query($conn, $sql);

                                $row=mysqli_num_rows($query_run);

                                echo'<h1>'.$row.'</h1>';


                                    ?>
                                <a class="small text-white stretched-link" href="./usersPage.php">View
                                    Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xl-3 col-md-6">
                        <div class="card bg-dark text-white mb-4">
                            <div class="card-body">Administrators</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <?php
                                // include "../TIMETRACK/control/connection.php";
                                // // COUNT By ID
                                // $sql = "SELECT id FROM users WHERE role=1 ORDER BY id";
                                // $query_run = mysqli_query($conn, $sql);

                                // $row=mysqli_num_rows($query_run);

                                // echo'<h1>'.$row.'</h1>';
                                    ?>

                                <a class="small text-white stretched-link" href="./administrators.php">View
                                    Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-dark text-white mb-4">
                            <div class="card-body">Attendance</div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <?php
                                include "../TIMETRACK/control/connection.php";
                                // COUNT By ID
                                $sql = "SELECT id FROM location ORDER BY id";
                                $query_run = mysqli_query($conn, $sql);

                                $row=mysqli_num_rows($query_run);

                                echo'<h1>'.$row.'</h1>';


                                    ?>
                                <a class="small text-white stretched-link" href="./attendanceAdmin.php">View
                                    Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>

    </div>

</body>

</html>