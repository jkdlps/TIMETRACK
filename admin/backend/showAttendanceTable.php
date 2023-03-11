<?php
include "connection.php";

$sql = "SELECT * FROM attendances";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        //table & Modal Buttons
        //Button trigger modal || id=#updatemodal  
        echo "<tr>
        <td>" . $row['id'] . "</td>
        <td>" . $row['employee_id'] . "</td>
        <td>" . $row['latitude'] . "</td>
        <td>" . $row['longitude'] . "</td>
        <td>" . $row['location'] . "</td>
        <td>" . $row['date'] . "</td>
        <td>" . $row['timein'] . "</td>
        <td>" . $row['timeout'] . "</td>
    </td>
    </tr>";
    }
} else {
    alerter("danger", "No results found.");
}
$conn->close();
?>