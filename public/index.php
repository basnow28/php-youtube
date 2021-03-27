<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../config/dependencies.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();

$dotenv->load(__DIR__ . '/../.env');

AppFactory::setContainer($container);

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->add(TwigMiddleware::createFromContainer($app));

$app->addRoutingMiddleware();

$app->addErrorMiddleware(true, false, false);

require_once __DIR__ . '/../config/routing.php';

$app->run();