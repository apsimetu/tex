<?php

include "db.inc.php";
$result = mysqli_query($con,"SELECT * FROM bets ORDER BY id DESC");

$query = mysqli_query($con,"SELECT status, COUNT(*) as number FROM bets WHERE status IN ('Laukiama','Laimėta','Pralaimėta','Grąžinta') GROUP BY status");

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * 5;
$sql =  mysqli_query ($con, "SELECT * FROM bets ORDER BY date DESC LIMIT $start_from, 5");

function getNumberOfPages($con) {
    $sql =  mysqli_query($con, "SELECT COUNT(id) FROM bets");
    $row = mysqli_fetch_row($sql);
    $total_records = $row[0];
    return ceil($total_records / 5);
}

function facebook_count($url){

    // Query in FQL
    $fql  = "SELECT share_count, like_count, comment_count ";
    $fql .= " FROM link_stat WHERE url = '$url'";

    $fqlURL = "https://api.facebook.com/method/fql.query?format=json&query=" . urlencode($fql);

    // Facebook Response is in JSON
    $response = file_get_contents($fqlURL);
    return json_decode($response);

}

function getRowStyle($rowStatus) {
    if ($rowStatus == 'Laimėta') {
        return 'background-color: #67FEA3';
    }
    if ($rowStatus == 'Pralaimėta') {
        return 'background-color: #FF4040';
    }
    if ($rowStatus == 'Grąžinta') {
        return 'background-color: #0E67DB';
    }
    if ($rowStatus == 'Laukiama') {
        return '';
    }
}

function toLikeOrNotToLike($rowId, $likeCount) {
    $fb = facebook_count("http://nimbo.lt/tex/{$rowId}/");

    return $fb[0]->like_count <= $likeCount;
}


$headerStats = [];
while ($row = mysqli_fetch_assoc($query)) {
    $headerStats[$row['status']] = $row['number'];
}

$contentRows = [];
while ($row = mysqli_fetch_assoc($sql)) {
    $contentRows[] = $row;
}

?>
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

    <div id="stats">

        <?php foreach ($headerStats as $status => $count): ?>
            <b><font><?= $status ?>: <?= $count ?></font></b>
        <?php endforeach; ?>

    </div>

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
            </tr>

            <?php foreach ($contentRows as $row): ?>

                <tr style="<?= getRowStyle($row['status']) ?>">
                    <td><?= $row['id'] ?></td>
                    <td><?= (new DateTime($row['date']))->format('Y-m-d') ?></td>
                    <td><a href="tipster.php?author=<?= $row['author'] ?>"><?= $row['author'] ?></a></td>
                    <td><a href="category.php?sport=<?= $row['sport'] ?>"><?= $row['sport'] ?></a></td>
                    <td><?= $row['matchas'] ?></td>
                    <td>
                        <?php if (toLikeOrNotToLike($row['id'], $row['like_count'])): ?>
                            <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fnimbo.lt%2Ftex%2F<?= $row['id'] ?>%2F&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:20px;width:100px;" allowTransparency="true"></iframe>
                        <?php else: ?>
                            <?= $row['bet'] ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $row['koef'] ?></td>
                    <td><?= $row['status'] ?></td>
                </tr>

            <?php endforeach; ?>

        </table>

        <center>
            <?php for ($i = 1; $i <= getNumberOfPages($con); $i++): ?>
                <a href="index.php?page=<?= $i ?>" class="page gradient"><?= $i ?></a>
            <?php endfor; ?>
        </center>

    </div>

    <div id="push"></div>

</div>

<div id="footer">
    <center>&copy; 2014 Martynas Stirbys</center>
</div>

</body>
</html>