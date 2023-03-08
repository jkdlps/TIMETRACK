<?php

function alerter($message, $type) {
    $alerter = "<div class='alert alert-$type m-3'>
    <span>$message</span>
    </div>";
    return $alerter;
}

?>