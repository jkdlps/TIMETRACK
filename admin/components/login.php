<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./styles/index.css">

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

    <div class="container col-xl-10 col-xxl-8  " id='body'>
        <div class="row align-items-center g-lg-5 py-5">
            <div class="col-lg-6 text-center text-lg-start">
                <img src="../images/admin.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700"
                    height="500" loading="lazy">
            </div>
            <div class="col-md-10 mx-auto col-lg-6">
                <form class=" p-4 p-md-5 border rounded-3 bg-light " action="./backend/loginbackend.php" method="POST">



                    <!--message-->


                    <!-- Email input -->
                    <h3 class='fw-normal text-start m-3'>LinawanOnline - Administrator Login </h3>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                        <input required type="email" name='email' class="form-control" id="exampleFormControlInput1"
                            placeholder="">
                    </div>


                    <!-- Password input -->
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Password</label>
                        <input required type="password" name='password' class="form-control"
                            id="exampleFormControlInput1" placeholder="">
                    </div>

                    <!-- button-->
                    <button type="submit" name="login" class="w-100 btn btn-lg btn-primary">Login</button>
                    <hr class="my-4">

                </form>
            </div>
        </div>
    </div>




</body>

</html>