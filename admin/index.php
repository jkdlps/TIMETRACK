<?php
include("includes/header.php");
?>

<!-- ADMIN LOGIN -->

<div class=" container col-xl-9 rounded-3 col-xxl-8 my-5">
    <div class="row align-items-center g-lg-5 mt-3">

        <div class="col-lg-6 text-center text-lg-start">
            <img src="./images/admin.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700"
                height="500" loading="lazy">
        </div>

        <div class="col-md-10 mx-auto col-lg-6 m-5">

            <form method="POST" action="./backend/loginbackend.php">
                <h2 class='fw-bold'>Login as Admin</h2>
                <!-- Email input with form validation -->
                <div class="mb-3 mt-4">
                    <label for="floatingInput">Email</label>
                    <input type="email" class="form-control" id="floatingInput" name="email" placeholder="Email">
                </div>

                <!-- Password input with form validation -->
                <div class="mb-3">
                    <label for="floatingPassword">Password</label>
                    <input type="password" class="form-control" id="floatingInput" name="password"
                        placeholder="Password">
                </div>

                <button class="w-100 btn btn-lg btn-success" name="submit" type="submit" value="Login">Login</button>

            </form>
        </div>


    </div>
</div>