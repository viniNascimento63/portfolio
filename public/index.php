<?php

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

//var_dump(__DIR__ . '/vendor/autoload.php');
require_once __DIR__ . '/vendor/autoload.php';

// Create App
$app = AppFactory::create();

// Create Twig
$twig = Twig::create(__DIR__ . '/templates', ['cache' => false]);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

require_once __DIR__ . '/routes/route-home.php';

// Run the application
$app->run();
