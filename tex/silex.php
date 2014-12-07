<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__.'/views',
]);

$con = mysqli_connect('localhost', 'nimbo_tex', 'tex', 'nimbo_tex');

if (!$con) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$app->get('/', function () use ($app, $con) {

    $query = mysqli_query($con,"SELECT status, COUNT(*) as number FROM bets WHERE status IN ('Laukiama','Laimėta','Pralaimėta','Grąžinta') GROUP BY status");

    $headerStats = [];
    while ($row = mysqli_fetch_assoc($query)) {
        $headerStats[$row['status']] = $row['number'];
    }

    $result = mysqli_query($con, "SELECT id FROM bets");
    $numberOfPages = ceil(mysqli_num_rows($result) / 5);

    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
    $start_from = ($page-1) * 5;
    $sql = mysqli_query ($con, "SELECT * FROM bets ORDER BY date DESC LIMIT $start_from, 5");

    $bets = [];
    while ($row = mysqli_fetch_assoc($sql)) {
        $bets[] = $row;
    }

    $fbTest = new Twig_SimpleFunction('showLikeButton', function($betId, $likeCount) {
        $url = "http://nimbo.lt/tex/{$betId}/";

        $fql  = "SELECT share_count, like_count, comment_count ";
        $fql .= " FROM link_stat WHERE url = '{$url}'";

        $fqlURL = "https://api.facebook.com/method/fql.query?format=json&query=" . urlencode($fql);

        $response = json_decode(file_get_contents($fqlURL));
        $fbLikeCount = $response[0]->like_count;

        return $fbLikeCount <= $likeCount;
    });

    $app['twig']->addFunction($fbTest);

    return $app['twig']->render('index.twig', [
        'headerStats' => $headerStats,
        'numberOfPages' => $numberOfPages,
        'bets' => $bets,
    ]);

});

$app->run();