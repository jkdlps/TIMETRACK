<?php
    // connect database
    $server = "localhost";
    $user = "u947188626__TIMETRACK";
    $pass = "*kN8xw+v$";
    $db = "u947188626__TIMETRACK";

    $conn = new mysqli($server, $user, $pass, $db);

    if($conn->connect_error) {
        echo "<div class='alert alert-danger m-3'>
        <span>Connection failed: $conn->connect_error</span>
    </div>";
    } echo "<div class='alert alert-success m-3'>
    <span>Connection successful.</span>
</div>";
?>



