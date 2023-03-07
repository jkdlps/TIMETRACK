<?php
    session_start();
?>
<!-- 
<div>
    <h3>Features:</h3>
    <ul>
        <li>Attendance Recording through Geolocation and Geofencing</li>
        <li>Printable Daily Time Record Generation & Change Request</li>
        <li>Leave Requesting & Management</li>
        <li>Employee & Employer Panels</li>
        <li>Employee Management</li>
        <li>Identification of Absent, Late, and On Time Employees</li>
        <li>One Time Passcode Verification through Email</li>
        <li>Password Change Request</li>
    </ul>
</div>

<div>
    <form action="login-form.php" method="get">
        <button type="submit">Log In</button>
    </form>
    <form action="signup-form.php" method="get">
        <button type="submit">Sign Up</button>
    </form>
    <hr>
</div>

<div>
    <h2>Documentation</h2>
    <div>
        <form action="desc_schema.php" method="get">
            <button type="submit">Read System Schema</button>
        </form>
    </div>
    <div>
        <form action="desc_structure.php" method="get">
            <button type="submit">Read System Structure</button>
        </form>
    </div>
</div>

<div>
    <table>
    <h4>System Created by:</h4>
    <p>BSIT 4-1 2022-2023 Group 6</p>
        <tr>
            <th>Developers</th>
            <th>Roles</th>
        </tr>
        <tr>
            <td>Casimiro, Alvin</td>
            <td>Data Analyst</td>
        </tr>
        <tr>
            <td>Del Poso, James Kevin</td>
            <td>Programmer</td>
        </tr>
        <tr>
            <td>Dimanlig, Rafaelle</td>
            <td>Researcher</td>
        </tr>
        <tr>
            <td>Marqueta, Marq Joshua</td>
            <td>Project Manager</td>
        </tr>
    </table>
</div>

</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       <meta http-equiv="x-ua-compatible" content="ie=edge">
       <title>Material Design for Bootstrap</title>
       <!-- Font Awesome -->
       <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
       <!-- Google Fonts Roboto -->
       <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
       <!-- Bootstrap core CSS -->
       <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
       <!-- Material Design Bootstrap -->
       <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
   </head>
   <body>
       <!-- Start your project here-->
       <div style="height: 100vh">
           
  <!--Main Navigation-->
  <header>
    <style>
      #intro {
        background-image: url("https://mdbootstrap.com/img/new/fluid/city/018.jpg");
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
        <a class="navbar-brand nav-link" href="https://mdbootstrap.com/docs/standard/">
          <strong>TIMETRACK</strong>
        </a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01"
          aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarExample01">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item active">
              <p>GPS Timekeeping System</p>
            </li>
            <li class="nav-item">
                <p>For Onsite and Remote Working Employees of Barangay Pulong Buhangin, Santa Maria, Bulacan</p>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Navbar -->

    <!-- Background image -->
    <div id="intro" class="bg-image shadow-2-strong">
      <div class="mask" style="background-color: rgba(0, 0, 0, 0.8);">
        <div class="container d-flex align-items-center justify-content-center text-center h-100">
          <div class="text-white">
            <h1 class="mb-3">Learn Bootstrap 5 with MDB</h1>
            <h5 class="mb-4">Best & free guide of responsive web design</h5>
            <a class="btn btn-outline-light btn-lg m-2" href="login-form.php" role="button"
              rel="nofollow">Log In</a>
            <a class="btn btn-outline-light btn-lg m-2" href="signup-form.php"
              role="button">Sign Up</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Background image -->
  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5">
    <div class="container">
      <!--Section: Content-->
      <section>
        <div class="row">
          <div class="col-md-6 gx-5 mb-4">
            <div class="bg-image hover-overlay ripple shadow-2-strong rounded-5" data-mdb-ripple-color="light">
              <img src="https://mdbootstrap.com/img/new/slides/031.jpg" class="img-fluid" />
              <a href="#!">
                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
              </a>
            </div>
          </div>
    </div>
    </section>
    </div>
    </main>
  <!--Main layout-->
       </div>
       <!-- End your project here-->
       <!-- jQuery -->
       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
       <!-- Bootstrap tooltips -->
       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
       <!-- Bootstrap core JavaScript -->
       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
       <!-- MDB core JavaScript -->
       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>
       </script>
   </body>
</html>