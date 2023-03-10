<?php
include("connection.php");


$sql = "SELECT * FROM admin";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        //table & Modal Buttons
        //Button trigger modal || id=#updatemodal  

        echo "<tr>
        <td>" . $row['id'] . "</td>
        <td>" . $row['name'] . "</td>
        <td>" . $row['email'] . "</td>
        <td>" . $row['password'] . "</td>
        <td>
        
        
        
    <a class='btn btn-dark btn-sm' name='update' href='./components/updateForm_admin.php   ?GETid=" . $row['id'] . "   '>  Update</a>
   

    </td>
    </tr>";

    }
} else {
    echo "0 results";
}
$conn->close();




?>