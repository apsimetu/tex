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

    return $app['twig']->render('index.twig', [
        'headerStats' => $headerStats,
    ]);

});

$app->run();