<?php

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