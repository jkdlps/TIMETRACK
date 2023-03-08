<?php

function alerter($message, $type) {
    "<div class='alert alert-$type m-3'>
    <span>$message</span>
    </div>";
    return;
}

?>