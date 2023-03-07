<?php
session_start();
include "header.php";
?>
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
            <form method="post" action="signup.php" class="bg-white rounded-5 shadow-5-strong p-5">
    <div class="form-outline">
    <label class="form-label" for="name">Name:</label>
        <input class="form-control" type="text" name="name" required>
    </div>

    <div class="form-outline">
    <label class="form-label" for="email">Email:</label>
        <input class="form-control" type="email" name="email" required>
    </div>

    <div class="form-outline">
    <label class="form-label" for="password">Password:</label>
        <input class="form-control" type="password" name="password" required>
    </div>

        <input class="btn btn-primary btn-block" type="submit" value="Signup">
</form>

<div>
    <form action="index.php" method="get" class="bg-white rounded-5 shadow-5-strong p-5">
        <button class="btn btn-secondary btn-block" type="submit">Back to Homepage</button>
    </form>
</div>
</div>
            </div>
          </div>
        </div>
      </div>
    </div>


<h2>Signup</h2>