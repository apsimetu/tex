<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>Redaguoti statymą | ADMIN</title>
<link rel="stylesheet" type="text/css" href="/tex/admin/style.css">
</head>
<body>
<div id="container">
	<div id="menu">
		<ul>
			<li><a href="/tex/admin/add.php">Pridėti statymą</a></li>
			<li><a href="/tex/admin/edit.php">Redaguoti statymus</a></li>
			<li><a href="/tex/">Pagrindinis puslapis</a></li>
		</ul>
	</div>
	<?php
include "../db.inc.php";
$result = mysqli_query($con,"SELECT * FROM bets ORDER BY id DESC");


$result2 = mysqli_query($con,"SELECT * FROM bets WHERE `status` = 'Laukiama'");
$num_rows = mysql_num_rows($result2);


echo "
<div id='content'>
" . $num_rows . " Rows\n
<table border='1' align='center'>
		<tr>
			<th>Statymo Nr.</th>
			<th>Data</th>
			<th>Tipsteris</th>
			<th>Šaka</th>
			<th>Įvykis</th>
			<th>Pasirinkimas</th>
			<th>LIKE Skaičius</th>
			<th>Koef</th>
			<th>Būsena</th>
			<th>Redaguot</th>
			<th>Trinti</th>
		</tr>";

while($row = mysqli_fetch_array($result))
{

if ($row['status'] == 'win') { $style = 'background-color: #67FEA3'; }
if ($row['status'] == 'lost') { $style = 'background-color: #FF4040'; }
if ($row['status'] == 'Waiting') { $style = ''; }

$row['date'] = date('Y-m-d');

echo "<tr style='".$style."'>";
echo "<td>" . $row['id'] . "</td>";
echo "<td>" . $row['date'] . "</td>";
echo "<td>" . $row['author'] . "</td>";
echo "<td>" . $row['sport'] . "</td>";
echo "<td>" . $row['matchas'] . "</td>";
echo "<td>" . $row['bet'] . "</td>";
echo "<td>" . $row['like_count'] . "</td>";
echo "<td>" . $row['koef'] . "</td>";
echo "<td>" . $row['status'] . "</td>";
echo "<td><a href=\"edit_data.php?id=".$row['id']."\"><img src='../admin/image/edit.png'/></a></td>";
echo "<td><a href=\"edit_data.php?id=".$row['status']."\"><img src='../admin/image/delete.png'/></a></td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>
	
</div>
</body>
</html>
