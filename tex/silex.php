<?php

require_once __DIR__.'/../vendor/autoload.php';

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

$app['repository'] = $app->share(function($app) {
    return new tex\utils\Repository($app['db']);
});

$app->get('/', function (Request $request) use ($app) {

    $headerStats = $app['repository']->getHeaderStats();

    $numberOfPages = $app['repository']->getNumberOfPages();

    $page = $request->get('page', 1);
    $start_from = ($page-1) * 5;

    $bets = $app['repository']->getPaginatedBets($start_from, 5);

    return $app['twig']->render('index.twig', [
        'headerStats' => $headerStats,
        'numberOfPages' => $numberOfPages,
        'bets' => $bets,
    ]);

});

$app->run();