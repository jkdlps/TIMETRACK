<?php
include "connection.php";
include "../TIMETRACK/backend/message.php";
// include('./includes/updateEmployeeModal.php');

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
        <td>
        <button type='button' class='btn btn-sm btn-warning' data-bs-toggle='modal' data-bs-target='#updateModal" . $row['id'] . "'>
            Update
        </button>
    </td>
        </div>
    </td>
    </tr>";
    }
} else {
    $_SESSION['message'] = "No results found.";
}
$conn->close();