<?php
session_start();
include "header.php";
?>
    <!-- <h2>Login</h2>
    <form method="post" action="login.php">
      <label>Email:</label>
      <input type="email" name="email" required>
      <br>
      <label>Password:</label>
      <input type="password" name="password" required>
      <br>
      <input type="submit" value="Login">
    </form>

<div>
    <form action="index.php" method="get">
        <button type="submit">Back to Homepage</button>
    </form>
</div> -->

  <!--Main Navigation-->
    <style>
      #intro {
        background-image: url(https://mdbootstrap.com/img/new/fluid/city/008.jpg);
        height: 100vh;
      }

      /* Height for devices larger than 576px */
      @media (min-width: 992px) {
        #intro {
          margin-top: -58.59px;
        }
      }

      .navbar .nav-link {
        color: #fff !important;
      }
    </style>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark d-none d-lg-block" style="z-index: 2000;">
      <div class="container-fluid">
        <!-- Navbar brand -->
        <a class="navbar-brand nav-link" href="index.php">
          <strong>TIMETRACK</strong>
        </a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01"
          aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarExample01">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item active">
              <a class="nav-link" aria-current="page" href="#intro">GPS Timekeeping System</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Navbar -->

    <!-- Background image -->
    <div id="intro" class="bg-image shadow-2-strong">
      <div class="mask d-flex align-items-center h-100" style="background-color: rgba(0, 0, 0, 0.8);">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-md-8">
            <form method="post" action="login.php" class="bg-white rounded-5 shadow-5-strong p-5">
  <div class="form-outline">
    <label class="form-label">Email:</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="form-outline">
    <label class="form-label">Password:</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <div class="form-outline">
                    <!-- 2 column grid layout for inline styling -->
                    <div class="row mb-4">
                  <div class="col d-flex justify-content-center">
                    <!-- Checkbox -->
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="remember-me" unchecked>
                      <label class="form-check-label" for="remember-me">
                        Remember me
                      </label>
                    </div>
                  </div>

                  <div class="col text-center">
                    <!-- Simple link -->
                    <a href="signup-form.php">No account yet? Sign up here</a>
                  </div>
                </div>
  </div>
    <input type="submit" value="Login" class="btn btn-primary btn-block">
</form>

<div class="container">
    <form action="index.php" method="get" class="bg-white rounded-3 shadow-3-strong p-3">
      <button type="submit" class="btn btn-secondary btn-block">Back to Homepage</button>
    </form>
</div>
</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Background image -->
  </header>
  <!--Main Navigation-->

