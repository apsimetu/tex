<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/utils/TwigExtensions.php';

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__.'/views',
]);

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    $twig->addExtension(new tex\utils\TwigExtensions($app));
    return $twig;
});

$app->register(new Silex\Provider\DoctrineServiceProvider(), [
   'db.options' => [
       'driver' => 'pdo_mysql',
       'host' => 'localhost',
       'user' => 'nimbo_tex',
       'password' => 'tex',
       'dbname' => 'nimbo_tex',
   ]
]);

$app->get('/', function (Request $request) use ($app) {

    $sql = "SELECT status, COUNT(id) AS number FROM bets GROUP BY status";
    $headerStats = $app['db']->fetchAll($sql);

    $numberOfBets = $app['db']->executeQuery("SELECT id FROM bets")->rowCount();
    $numberOfPages = ceil($numberOfBets / 5);

    $page = $request->get('page', 1);
    $start_from = ($page-1) * 5;

    $stmt = $app['db']->prepare("SELECT * FROM bets ORDER BY date DESC LIMIT :offset, :limit");
    $stmt->bindValue('offset', $start_from, PDO::PARAM_INT);
    $stmt->bindValue('limit', 5, PDO::PARAM_INT);
    $stmt->execute();
    $bets = $stmt->fetchAll();

    return $app['twig']->render('index.twig', [
        'headerStats' => $headerStats,
        'numberOfPages' => $numberOfPages,
        'bets' => $bets,
    ]);

});

$app->run();