<?php
include "db.inc.php";
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * 2;
$sql =  mysqli_query ($con, "SELECT * FROM bets ORDER BY date DESC LIMIT $start_from, 2");
?>
<table>
<tr><td>Name</td><td>Bet</td></tr>
<?php
while ($row = mysqli_fetch_assoc($sql)) {
?>
            <tr>
            <td><? echo $row["matchas"]; ?></td>
            <td><? echo $row["bet"]; ?></td>
            </tr>
<?php
};

$sql =  mysqli_query ($con, "SELECT COUNT(id) FROM bets");
$row = mysqli_fetch_row($sql);
$total_records = $row[0];
$total_pages = ceil($total_records / 2);
  
for ($i=1; $i<=$total_pages; $i++) {
            echo "<a href='pagination.php?page=".$i."'>".$i."</a> ";
}; 

?>



</table>