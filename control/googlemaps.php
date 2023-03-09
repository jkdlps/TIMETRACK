<?php
include "conn.php";
$rows = mysqli_query($conn, "SELECT * FROM attendance");
$i = 1;

foreach($rows as $row) :
?>

<tr>
    <td>
        <?php echo $i++; ?>
    </td>
    <td>
        <?php echo $row["name"]; ?>
    </td>
    <td>
        <?php echo $row["email"]; ?>
    </td>
    <td style="width: 450px; height: 450px;">
        <iframe src="https://maps.google.com/q=<?php echo $row['latitude'];?>,<?php echo $row['longitude'];?>&hl=es;z=14&output=embed"></iframe>
    </td>
</tr>
<?php endforeach; ?>