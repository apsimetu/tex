<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>Rezultatai</title>
<link rel="stylesheet" type="text/css" href="/tex/style.css">
</head>
<body> 

<div id="container">
	<div id="header">
		<center><h1>Pasirinkite tipsteri</h1></center>
		<div id="tipster"><a href="#"><img src="http://nimbo.lt/tex/image/paulius.png" /><br />Paulius</a></div>
		<div id="tipster"><a href="#"><img src="http://nimbo.lt/tex/image/thomas.png" /><br />Thomas</a></div>
		<div id="tipster"><a href="#"><img src="http://nimbo.lt/tex/image/anglas.png" /><br />Anglas</a></div>
	</div>
</div>




<?php
include "db.inc.php";
$autorius = $_GET['author'];
$result = mysqli_query($con,"SELECT * FROM bets WHERE author='$autorius' ORDER BY id DESC");



?>
<div id="content">
	Statistika: Laimeta 

</div>

<?php


echo "
<div id='content'>

<table border='1'>
		<tr>
			<th style='width:5px;'>Nr.</th>
			<th>Data</th>
			<th>Tipsteris</th>
			<th>Šaka</th>
			<th>Ivykis</th>
			<th>Pasirinkimas</th>
			<th>Koef</th>
			<th>Busena</th>
		</tr>";


		

		
while($row = mysqli_fetch_array($result))
{


if ($row['status'] == 'Laimėta') { $style = 'background-color: #67FEA3'; }
if ($row['status'] == 'Pralaimėta') { $style = 'background-color: #FF4040'; }
if ($row['status'] == 'Grąžinta') { $style = 'background-color: #0E67DB'; }
if ($row['status'] == 'Laukiama') { $style = ''; }


$row['date'] = date('Y-m-d');

echo "<tr style='".$style."'>";
echo "<td>" . $row['id'] . "</td>";
echo "<td>" . $row['date'] . "</td>";
echo "<td>" . $row['author'] . "</td>";
echo "<td>" . $row['sport'] . "</td>";
echo "<td>" . $row['matchas'] . "</td>";
echo "<td>" . $row['bet'] . "</td>";
echo "<td>" . $row['koef'] . "</td>";
echo "<td><b>" . $row['status'] . "</b></td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>
	

</div>

<div id="footer">
	<center>&copy; 2014 Martynas Stirbys</center>
</div>


</body>
</html>