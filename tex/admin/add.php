<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>Pridėti statymą | ADMIN</title>
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
	<h1>Statymo pridėjimas</h1>
<?php if (!empty($_POST)) { ?>
	<?php

$host="localhost"; // Host name
$username="nimbo_tex"; // Mysql username
$password="tex"; // Mysql password
$db_name="nimbo_tex"; // Database name
$tbl_name="bets"; // Table name

// Connect to server and select database.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

//inserting data order

$author = mysql_real_escape_string($_POST['author']);
$sport = mysql_real_escape_string($_POST['sport']);
$matchas = mysql_real_escape_string($_POST['matchas']);
$bet = mysql_real_escape_string($_POST['bet']);
$like_count = mysql_real_escape_string($_POST['like_count']);
$koef = mysql_real_escape_string($_POST['koef']);
$status = mysql_real_escape_string($_POST['status']);


$order = "INSERT INTO bets
			(author, sport, matchas, bet, like_count, koef, status)
			VALUES
			('$author','$sport','$matchas','$bet','$like_count', '$koef','$status')";

//declare in the order variable
$result = mysql_query($order);	//order executes
if($result){
	echo("<br><h1> Sėkmingai pridėtas statymas</h1>");
	error_reporting(E_ALL);
ini_set("display_errors", 1);


} else{
	echo("<br>Input data is fail");
	error_reporting(E_ALL);
ini_set("display_errors", 1);

}
?>

<?php  } else { ?>

	
      <table border="1">
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
        <tr>
          <td>Autorius</td>
          <td><input type="text" name="author" size="40">
          </td>
        </tr>
	<tr>
	<td>Sporto šaka</td>
	<td><select name="sport" id="sport">
            <option value = "Futbolas">Futbolas</option>
            <option value = "Krepšinis">Krepšinis</option>
            <option value = "Ledo ritulis">Ledo ritulis</option>
    </select></td>
	</tr>
		        <tr>
          <td>Įvykis</td>
          <td><input type="text" name="matchas" size="40">
          </td>
        </tr>
		        <tr>
          <td>Statymas</td>
          <td><input type="text" name="bet" size="40">
          </td>
        </tr>
		
				        <tr>
          <td>LIKE Skaičius</td>
          <td><input type="text" name="like_count" size="40">
          </td>
        </tr>
		        <tr>
          <td>Koeficientas</td>
          <td><input type="text" name="koef" size="40">
          </td>
        </tr>
	<tr>
	<td>Statusas</td>
	<td><select name="status" id="status" size="4">
			<option value = "Laukiama">Laukiama</option>
            <option value = "Laimėta">Laimėta</option>
            <option value = "Pralaimėta">Pralaimėta</option>
            <option value = "Grąžinta">Grąžinta</option>
    </select></td>
	</tr>
        <tr>
          <td></td>
          <td align="right"><input type="submit" 
          name="submit" value="Sent"></td>
        </tr>
        </table>
</div>
<?php } ?>
</body>
</html>
