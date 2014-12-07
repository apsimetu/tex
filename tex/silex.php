<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__.'/views',
]);

$app->register(new Silex\Provider\DoctrineServiceProvider(), [
   'db.options' => [
       'driver' => 'pdo_mysql',
       'host' => 'localhost',
       'user' => 'nimbo_tex',
       'password' => 'tex',
       'dbname' => 'nimbo_tex',
   ]
]);

$con = mysqli_connect('localhost', 'nimbo_tex', 'tex', 'nimbo_tex');

if (!$con) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$app->get('/', function () use ($app, $con) {

    $sql = "SELECT status, COUNT(id) AS number FROM bets GROUP BY status";
    $headerStats = $app['db']->fetchAll($sql);

    $numberOfBets = $app['db']->executeQuery("SELECT id FROM bets")->rowCount();
    $numberOfPages = ceil($numberOfBets / 5);

    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
    $start_from = ($page-1) * 5;

    $stmt = $app['db']->prepare("SELECT * FROM bets ORDER BY date DESC LIMIT :offset, :limit");
    $stmt->bindValue('offset', $start_from, PDO::PARAM_INT);
    $stmt->bindValue('limit', 5, PDO::PARAM_INT);
    $stmt->execute();
    $bets = $stmt->fetchAll();

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