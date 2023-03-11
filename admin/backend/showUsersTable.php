<?php
include "connection.php";

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        // if($row['designation'] == 1) {
        //     $designation = "onsite";
        // } else {
        //     $designation = "remote";
        // }
        //table & Modal Buttons
        //Button trigger modal || id=#updatemodal  
        echo "<tr>
        <td>" . $row['id'] . "</td>
        <td>" . $row['firstname'] . "</td>
        <td>" . $row['lastname'] . "</td>
        <td>" . $row['email'] . "</td>
        <td>" . $row['role'] . "</td>
        <td>" . $row['designation'] . "</td>
        <td>" . $row['date_created'] . "</td>
        <td>" . $row['date_updated'] . "</td>
        <td>
        <div class='row m-1'>
            <div class='col-lg-6'>
                <a class='btn btn-dark btn-sm mx-2' name='update' href='../components/updateForm_users.php   ?GETid=" . $row['id'] . "   '>  Update</a>
            </div>
        </div>
    </td>
    </tr>";
    }
} else {
    alerter("danger", "No results found.");
}
$conn->close();