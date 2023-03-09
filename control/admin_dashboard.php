<?php
session_start();
include "../functions.php";
db();
head("Admin Dashboard");
?>

    <div class="container-fluid text-center mt-5 p-3">
        <div>
            <h1 class="h1">Admin Dashboard | Timetrack</h1>
        </div>
        <div>
            <a href="../logout.php">Log Out</a>
        </div>
    </div>
</body>
</html>