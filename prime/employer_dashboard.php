<?php
session_start();
include "conn.php";
include "header.php";
?>

<!-- <div>
    <p>Welcome, <?php echo $_SESSION['user_name']; ?></p>
    <h2>Employer Dashboard</h2>
</div>

<div>
    <h3>Manage Account</h3>
    <form action="update-form.php" method="post">
        <button type="submit">Update Info</button>
    </form>
    <form action="employee_dashboard.php" method="post">
        <button type="submit">View Dashboard as Employee</button>
    </form>
    <form action="logout.php" method="get">
        <button type="submit">Log Out</button>
    </form>
</div>

<div>
    <h3>Manage Employees</h3>
    <form action="employer_view_employees.php" method="post">
        <button type="submit">View Employees</button>
    </form> -->
    <!-- <form action="employer_view_lates.php" method="post">
        <button type="submit">View Late Employees</button>
    </form>
    <form action="employer_view_absences.php" method="post">
        <button type="submit">View Absent Employees</button>
    </form>
    <form action="employer_view_ontime.php" method="post">
        <button type="submit">View On Time Employees</button>
    </form> -->
    <!-- <form action="employer_view_admins.php" method="post">
        <button type="submit">View Admins</button>
    </form> -->

    <!-- <h3>Manage Daily Time Records</h3>
    <form action="employer_view_dtr.php" method="post">
        <button type="submit">View Daily Time Records</button>
    </form>
    <form action="employer_dtr_requests.php" method="post">
        <button type="submit">View Daily Time Record Change Requests</button>
    </form>

    <h3>Manage Leaves</h3>
    <form action="employer_view_leaves.php" method="post">
        <button type="submit">View Employees on Leave</button>
    </form>
    <form action="employer_view_leave_requests.php" method="post">
        <button type="submit">View Leave Requests</button>
    </form>
</div> -->


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
            ><span>Employer Dashboard</span>
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
           href="employer_view_employees.php"
           class="list-group-item list-group-item-action py-2 ripple"
           >
          <i class="fas fa-chart-pie fa-fw me-3"></i><span>View Employees</span>
        </a>
        <a
           href="employer_view_admins.php"
           class="list-group-item list-group-item-action py-2 ripple"
           ><i class="fas fa-chart-bar fa-fw me-3"></i><span>View Admins</span></a
          >
        <a
           href="employer_view_dtr.php"
           class="list-group-item list-group-item-action py-2 ripple"
           ><i class="fas fa-globe fa-fw me-3"></i
          ><span>View Daily Time Records</span></a
          >
          <a
           href="employee_dtr_requests.php"
           class="list-group-item list-group-item-action py-2 ripple"
           ><i class="fas fa-globe fa-fw me-3"></i
          ><span>View Daily Time Record Change Requests</span></a
          >
          <a
           href="employee_view_leaves.php"
           class="list-group-item list-group-item-action py-2 ripple"
           ><i class="fas fa-globe fa-fw me-3"></i
          ><span>View Employees on Leave</span></a
          >
          <a
           href="employee_view_leave_requests.php"
           class="list-group-item list-group-item-action py-2 ripple"
           ><i class="fas fa-globe fa-fw me-3"></i
          ><span>View Leave Requests</span></a
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
      <!-- Search form -->
      <!-- <form class="d-none d-md-flex input-group w-auto my-auto">
        <input
               autocomplete="off"
               type="search"
               class="form-control rounded"
               placeholder='Search (ctrl + "/" to focus)'
               style="min-width: 225px"
               />
        <span class="input-group-text border-0"
              ><i class="fas fa-search"></i
          ></span>
      </form> -->

      <!-- Right links -->
      <ul class="navbar-nav ms-auto d-flex flex-row">
        <!-- Notification dropdown -->
        <li class="nav-item dropdown">
          <a
             class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow"
             href="#"
             id="navbarDropdownMenuLink"
             role="button"
             data-mdb-toggle="dropdown"
             aria-expanded="false"
             >
            <!-- <i class="fas fa-bell"></i>
            <span class="badge rounded-pill badge-notification bg-danger"
                  >1</span
              > -->
          </a>
          <ul
              class="dropdown-menu dropdown-menu-end"
              aria-labelledby="navbarDropdownMenuLink"
              >
            <li><a class="dropdown-item" href="#">Some news</a></li>
            <li><a class="dropdown-item" href="#">Another news</a></li>
            <li>
              <a class="dropdown-item" href="#">Something else here</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
</header>
<!--Main Navigation-->