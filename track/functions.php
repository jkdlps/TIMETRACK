<?php

function alerter($message, $type) {
    echo "<div class='alert alert-$type m-3'>
    <span>$message</span>
    </div>";
}

?>