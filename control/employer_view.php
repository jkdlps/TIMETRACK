<?php
    session_start();
    // Connect to the database
    include "functions.php";
    db();
    head("View Employees");
?>

<h1>Employees</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Position</th>
        </tr>
    </thead>
    <tbody>
        <?php            
        // Query the database for employees
        $result = mysqli_query($con, "SELECT * FROM users");
        
        // Loop through the result set and display each employee
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['designation'] . "</td>";
            echo "</tr>";
        }
        
        // Close the database connection
        mysqli_close($con);
        ?>
    </tbody>
</table>