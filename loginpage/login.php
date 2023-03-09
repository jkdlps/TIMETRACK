<div class="col-lg-6 text-center text-lg-start">
                <img class="img-fluid" src="./images/login.png" />
            </div>
            <div class="col-md-10 mx-auto col-lg-5">

                <form class="p-4 p-md-5  rounded-3" method="post">
                    
                    <?php
                    include("./backend/loginBackend.php");
                    ?>

                    <h1 class="my-2">Login</h1>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput" name="email"
                            placeholder="name@example.com">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" name="password"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary mb-3" type="submit" value="Login">Login</button>
                    <small class="text-muted">Don't have an account?<a href="./signuppage.php"> Sign Up </a></small>
                    <hr class="my-4">
                    <small class="text-muted mb-3"> By using this service, you understood and agree to the Linawan
                        Christian Church <a href="terms.php"> Terms of Use and Privacy Statement</small>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>