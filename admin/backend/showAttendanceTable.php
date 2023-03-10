<?php
include "../TIMETRACK/control/connection.php";

$sql = "SELECT * FROM location";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        //table & Modal Buttons
        //Button trigger modal || id=#updatemodal  
        echo "<tr>
        <td>" . $row['id'] . "</td>
        <td>" . $row['longitude'] . "</td>
        <td>" . $row['latitude'] . "</td>
        <td>" . $row['time'] . "</td>
        <td>" . $row['time'] . "</td>
        <td>" . $row['date'] . "</td>
    </td>
    </tr>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>