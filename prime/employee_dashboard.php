<?php
session_start();
include "conn.php";
include "header.php";
?>

<!-- <div>
    <p>Welcome, <?php echo $_SESSION['user_name']; ?></p>
    <h2>Employee Dashboard</h2>
</div>

<div>
    <h3>Manage Account</h3>
    <form action="update-form.php" method="post">
        <button type="submit">Update Info</button>
    </form>
    <?php
    // if($_SESSION['user_role'] == 1) {
    //     echo "
    //         <form action='employer_dashboard.php' method='post'>
    //             <button type='submit'>View Dashboard as Employer</button>
    //         </form>";
    // }
    ?>
    <form action="logout.php" method="get">
        <button type="submit">Log Out</button>
    </form>
</div>

<div>
    <h3>Your Attendance:</h3> -->
    <!-- <script src="take_attendance.js"></script>
        <button onclick="getLocation()">Time In</button> -->
    <!-- <form action="employee_attendance.php" method="post">
        <button type="submit">Attendance Page</button>
    </form> -->
    <!-- <form action="attendance.php" method="post">
        <button type="submit">Attend</button>
    </form> -->
    <!-- <form action="submit_attendance.php" method="post">
        <button type="submit">Take Attendance</button>
    </form> -->
    <!-- <form action="timein.php" method="post">
        <button type="submit">Time In</button>
    </form>
</div>

<div>
    <h3>Manage Your Daily Time Records</h3>
    <form action="employee_view_dtr.php" method="post">
        <button type="submit">View Your Daily Time Records</button>
    </form> -->
    <!-- <form action="employee_request_dtr.php" method="post">
        <button type="submit">Request Daily Time Record Change</button>
    </form> -->
    <!-- <h3>Manage Your Leave</h3>
    <form action="employee_view_leaves.php" method="post">
        <button type="submit">View Your Leaves</button>
    </form> -->
    <!-- <form action="employee_request_leave.php" method="post">
        <button type="submit">Request Leave</button>
    </form> -->
<!-- </div> -->

<!--  -->

<!--Main Navigation-->
<header>
  <!-- Sidebar -->
  <nav
       id="sidebarMenu"
       class="collapse d-lg-block sidebar collapse bg-white"
       >
    <div class="position-sticky">
      <div class="list-group list-group-flush mx-3 mt-4">
        <a
           href="employee_dashboard.php"
           class="list-group-item list-group-item-action py-2 ripple"
           aria-current="true active"
           >
          <i class="fas fa-tachometer-alt fa-fw me-3"></i
            ><span>Employee Dashboard</span>
        </a>
        <a
           href="update-form.php"
           class="list-group-item list-group-item-action py-2 ripple"
           >
          <i class="fas fa-chart-area fa-fw me-3"></i
            ><span>Update Info</span>
        </a>
        <?php 
        if($_SESSION['user_role'] == 1) {
            echo '<a
            href="employer_dashboard.php"
            class="list-group-item list-group-item-action py-2 ripple"
            ><i class="fas fa-lock fa-fw me-3"></i><span>View as Employer</span></a
           >';
        }
        ?>
        <a
           href="logout.php"
           class="list-group-item list-group-item-action py-2 ripple"
           ><i class="fas fa-chart-line fa-fw me-3"></i
          ><span>Log Out</span></a
          >
        <a
           href="employee_attendance.php"
           class="list-group-item list-group-item-action py-2 ripple"
           >
          <i class="fas fa-chart-pie fa-fw me-3"></i><span>Take Attendance</span>
        </a>
        <a
           href="employee_view_dtr.php"
           class="list-group-item list-group-item-action py-2 ripple"
           ><i class="fas fa-chart-bar fa-fw me-3"></i><span>View Your DTRs</span></a
          >
        <a
           href="employee_view_leaves.php"
           class="list-group-item list-group-item-action py-2 ripple"
           ><i class="fas fa-globe fa-fw me-3"></i
          ><span>View Your Leaves</span></a
          >
      </div>
    </div>
  </nav>
  <!-- Sidebar -->

  <!-- Navbar -->
  <nav
       id="main-navbar"
       class="navbar navbar-expand-lg navbar-light bg-white fixed-top"
       >
    <!-- Container wrapper -->
    <div class="container-fluid">
      <!-- Toggle button -->
      <button
              class="navbar-toggler"
              type="button"
              data-mdb-toggle="collapse"
              data-mdb-target="#sidebarMenu"
              aria-controls="sidebarMenu"
              aria-expanded="false"
              aria-label="Toggle navigation"
              >
        <i class="fas fa-bars"></i>
      </button>

      <!-- Brand -->
      <a class="navbar-brand" href="employee_dashboard.php">
<strong>TIMETRACK</strong>
      </a>
      </ul>
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
</header>
<!--Main Navigation-->