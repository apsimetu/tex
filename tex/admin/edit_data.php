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

// get value of id that sent from address bar
$id=$_GET['id'];

// Retrieve data from database
$sql="SELECT * FROM $tbl_name WHERE id='$id'";
$result=mysql_query($sql);

$row=mysql_fetch_array($result);
?>
	
<table border="1">
        <form action="../admin/edit_update.php" method="post">
		<input type="hidden" name="id" value="<?php echo $row['id'];?>">
        <tr>
          <td>Autorius</td>
          <td><input type="text" name="author" size="40" value="<?php echo $row['author'];?>">
          </td>
        </tr>
	<tr>
	<td>Sporto šaka</td>
	<td><select name="sport" id="sport">
			<option value = "Futbolas" <?php if ($row['sport']=='Futbolas') { ?>selected="selected"<?php } ?>>Futbolas</option>
			<option value = "Krepšinis" <?php if ($row['sport']=='Krepšinis') { ?>selected="selected"<?php } ?>>Krepšinis</option>
			<option value = "Tenisas" <?php if ($row['sport']=='Tenisas') { ?>selected="selected"<?php } ?>>Tenisas</option>
    </select></td>
	</tr>
		        <tr>
          <td>Įvykis</td>
          <td><input type="text" name="matchas" size="40" value="<?php echo $row['matchas'];?>">
          </td>
        </tr>
		        <tr>
          <td>Statymas</td>
          <td><input type="text" name="bet" size="40" value="<?php echo $row['bet'];?>">
          </td>
        </tr>
				        <tr>
          <td>LIKE Skaičius</td>
          <td><input type="text" name="like_count" size="40" value="<?php echo $row['like_count'];?>">
          </td>
        </tr>
		        <tr>
          <td>Koeficientas</td>
          <td><input type="text" name="koef" size="40" value="<?php echo $row['koef'];?>">
          </td>
        </tr>
	<tr>
	<td>Statusas</td>
	<td><select name="status" id="status" size="4">
			<option value = "Laukiama" <?php if ($row['status']=='Laukiama') { ?>selected="selected"<?php } ?>>Laukiama</option>
            <option value = "Laimėta" <?php if ($row['status']=='Laimėta') { ?>selected="selected"<?php } ?>>Laimėta</option>
            <option value = "Pralaimėta" <?php if ($row['status']=='Pralaimėta') { ?>selected="selected"<?php } ?>>Pralaimėta</option>
            <option value = "Grąžinta" <?php if ($row['status']=='Grąžinta') { ?>selected="selected"<?php } ?>>Grąžinta</option>
    </select></td>
	</tr>
        <tr>
          <td></td>
          <td align="right"><input type="submit" 
          name="submit" value="Sent"></td>
        </tr>
        </table>
		
		<?php 
mysql_close();?>
</div>
</body>
</html>
