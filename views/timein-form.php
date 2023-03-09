<?php
session_start();
include "../control/functions.php";
head("Time In");
?>

<h1>Time In</h1>
    <?php if (isset($error)) { alerter("$error", "danger"); } ?>
<form method="POST" action="../control/timein.php">
<label for="latitude">Latitude:</label>
<input type="text" name="latitude" required><br><br>
<label for="longitude">Longitude:</label>
<input type="text" name="longitude" required><br><br>
<input type="submit" value="Time In">
</form>