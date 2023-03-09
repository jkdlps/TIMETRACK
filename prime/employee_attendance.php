  <!--Main Navigation-->
  <header>
    <!-- Intro settings -->
    <style>
      /* Default height for small devices */
      #intro {
        height: 600px;
        /* Margin to fix overlapping fixed navbar */
        /* margin-top: 58px; */
      }
      @media (max-width: 991px) {
              #intro {
              /* Margin to fix overlapping fixed navbar */
              margin-top: 45px;
      	}
      }
    </style>

    <!-- Background image -->
    <div id="intro" class="p-5 text-center bg-image shadow-1-strong"
      style="background-image: url('https://mdbootstrap.com/img/new/slides/205.jpg');">
      <div class="mask" style="background-color: rgba(0, 0, 0, 0.7);">
        <div class="d-flex justify-content-center align-items-center h-100">
          <div class="text-white px-4">
            <h1 class="mb-3">Employee Attendance</h1>

            <!-- Time Counter -->
            <h3 id="time-counter" class="border border-light my-4 p-4"></h3>

            <a class="btn btn-outline-light btn-lg m-2" href="timein.php" role="button">Time In</a>
            <a class="btn btn-outline-light btn-lg m-2" href="timeout.php" role="button">Time Out</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Background image -->
  </header>
  <!--Main Navigation-->