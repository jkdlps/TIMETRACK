<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <h1 class='text-center mt-5'>Employees Table</h1>
    <a href="../add_employee.php" class="btn btn-secondary">Add Employee</a>
    <!--Table-->
    <div class="container-fluid  pt-4" id='body'>
        <div class="table-responsive text-center ">
            <table class="table table-bordered bg-white " id="datatable">
                <thead class="bg-primary text-light">
                    <tr>
                        <th>id</th>
                        <th>name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                include("./backend/showUsersTable.php");
                ?>
                </tbody>


            </table>

        </div>


    </div>
    <!--End of Table-->

</body>

</html>