<?php
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function query ($sql, $data=null) {
    include "conn.php";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("$bind", null);
    $stmt->execute($data);
}