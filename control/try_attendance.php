<?php
session_start();
include "functions.php";
?>

<script>
    function showPosition(position) {
        document.querySelector('.myForm input[name = "latitude"]').value = position.coords.latitude;
        document.querySelector('.myForm input[name = "longitude"]').value = position.coords.longitude;
    }

    function showError(error) {
        switch(error.code) {
            case error.PERMISSION_DENIED:
                alert("Geolocation must be allowed");
                location.reload();
                break;
        }
    }
</script>