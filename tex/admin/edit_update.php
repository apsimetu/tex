<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>Redagavimas statymo | ADMIN</title>
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
	
	<div id="content">
	
		<?php
$host="localhost"; // Host name
$username="nimbo_tex"; // Mysql username
$password="tex"; // Mysql password
$db_name="nimbo_tex"; // Database name
$tbl_name="bets"; // Table name

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

$id = mysql_real_escape_string($_POST['id']);
$author = mysql_real_escape_string($_POST['author']);
$sport = mysql_real_escape_string($_POST['sport']);
$matchas = mysql_real_escape_string($_POST['matchas']);
$bet = mysql_real_escape_string($_POST['bet']);
$like_count = mysql_real_escape_string($_POST['like_count']);
$koef = mysql_real_escape_string($_POST['koef']);
$status = mysql_real_escape_string($_POST['status']);

// update data in mysql database
$sql="UPDATE bets SET author='$author', sport='$sport', matchas='$matchas', bet='$bet', like_count='$like_count', koef='$koef', status='$status' WHERE id='$id'";
$result=mysql_query("SET author = 'utf8', sport = 'utf8', matchas = 'utf8', bet = 'utf8', status = 'utf8'");
$result=mysql_query($sql);


// if successfully updated.
if($result){
echo "Successful";
echo "<BR>";
echo "<a href='updt.php'>View result</a>";
}

else {
echo "ERROR";
}
?>


</div>
</body>
</html>
