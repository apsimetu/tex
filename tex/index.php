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
		<center><h1>Pasirinkite tipsterį</h1></center>
		<div id="tipsters">
		<div id="tipster"><a href="/tex/tipster.php?author=Paulius"><img src="http://nimbo.lt/tex/image/paulius.png" /><br />Paulius</a></div>
		<div id="tipster"><a href="/tex/tipster.php?author=Thomas"><img src="http://nimbo.lt/tex/image/thomas.png" /><br />Thomas</a></div>
		<div id="tipster"><a href="/tex/tipster.php?author=Anglas"><img src="http://nimbo.lt/tex/image/anglas.png" /><br />Anglas</a></div>
		</div>
	</div>

<?php
include "db.inc.php";
$result = mysqli_query($con,"SELECT * FROM bets ORDER BY id DESC");

$query = mysqli_query($con,"SELECT status, COUNT(*) as number FROM bets WHERE status IN ('Laukiama','Laimėta','Pralaimėta','Grąžinta') GROUP BY status");

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * 5;
$sql =  mysqli_query ($con, "SELECT * FROM bets ORDER BY date DESC LIMIT $start_from, 5");

function facebook_count($url){
 
    // Query in FQL
    $fql  = "SELECT share_count, like_count, comment_count ";
    $fql .= " FROM link_stat WHERE url = '$url'";
 
    $fqlURL = "https://api.facebook.com/method/fql.query?format=json&query=" . urlencode($fql);
 
    // Facebook Response is in JSON
    $response = file_get_contents($fqlURL);
    return json_decode($response);
 
}

?>
<div id="stats">

<?php while ($row = mysqli_fetch_assoc($query)) {
    echo '<b><font>' . $row['status'] . ': ' . $row['number'] . '</font></b>';
}?>


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
			<th>Įvykis</th>
			<th>Pasirinkimas</th>
			<th>Koef</th>
			<th>Būsena</th>
		</tr>";

		
while($row = mysqli_fetch_array($result))
while ($row = mysqli_fetch_assoc($sql)) {
{

if ($row['status'] == 'Laimėta') { $style = 'background-color: #67FEA3'; }
if ($row['status'] == 'Pralaimėta') { $style = 'background-color: #FF4040'; }
if ($row['status'] == 'Grąžinta') { $style = 'background-color: #0E67DB'; }
if ($row['status'] == 'Laukiama') { $style = ''; }

$row['date'] = date('Y-m-d');

echo "<tr style='".$style."'>";
echo "<td>" . $row['id'] . "</td>";
echo "<td>" . $row['date'] . "</td>";
echo "<td><a href='tipster.php?author=" . $row['author'] . "'>" . $row['author'] . "</a></td>";
echo "<td><a href='category.php?sport=" . $row['sport'] . "'>".$row['sport'] . "</a></td>";
echo "<td>" . $row['matchas'] . "</td>";
?>

<td>
<?php

	$fb = facebook_count("http://nimbo.lt/tex/".$row['id']."/");
	$likas = $fb[0]->like_count;
	
// facebook like count
if ($fb[0]->like_count <= $row['like_count']) { ?>
	<iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fnimbo.lt%2Ftex%2F<?php echo $row['id']; ?>%2F&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:20px;width:100px;" allowTransparency="true"></iframe>
<?php
} else {
	echo "" . $row['bet'] . "";
}

?>
	</td>
<?php
echo "<td>" . $row['koef'] . "</td>";
echo "<td><b>" . $row['status'] . "</b></td>";
echo "</tr>";
} }
echo "</table>";

$sql =  mysqli_query ($con, "SELECT COUNT(id) FROM bets");
$row = mysqli_fetch_row($sql);
$total_records = $row[0];
$total_pages = ceil($total_records / 5);
  
 echo" <center>";
for ($i=1; $i<=$total_pages; $i++) {
echo "<a href='index.php?page=".$i."' class='page gradient'>".$i."</a>";
};
echo "</center>";

mysqli_close($con);
?>
	

</div>
	<div id="push"></div>
</div>
<div id="footer">
	<center>&copy; 2014 Martynas Stirbys</center>
</div>


</body>
</html>