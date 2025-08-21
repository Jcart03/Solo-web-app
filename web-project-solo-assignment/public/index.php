<?php
/**
 * Entry point for the Slim application
 *
 * Loads Composer autoloader with 'vendor/autoload.php'
 * creates the Slim app instance
 * registers application routes
 *
 */
 use Slim\Factory\AppFactory;
 use Slim\Views\Twig;
 use Slim\Views\TwigMiddleware;
 use P2718293\SoloWebDev2025\routes\Web;
 
require_once __DIR__. '/../vendor/autoload.php';

$app = AppFactory::create();

$twig = Twig::create(__DIR__.'/../src/templates', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));



//updated for SonarQube Error
Web::register($app, $twig);

$app->run();
