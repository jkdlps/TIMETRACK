<?php

function generateRandomEmployeeId($length = 8) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $max = strlen($characters) - 1;
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $max)];
    }
    return $randomString;
}

$employeeid = generateRandomEmployeeId(8);
echo $employeeid;
?>