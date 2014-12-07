<?php

require_once __DIR__.'/../vendor/autoload.php';

require_once __DIR__.'/bootstrap.php';

use Symfony\Component\HttpFoundation\Request;

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