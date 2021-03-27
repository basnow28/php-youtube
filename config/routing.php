<?php
declare(strict_types=1);

use Youtube\Controller\HomeController;
use Youtube\Middleware\BeforeMiddleware;
use Youtube\Middleware\StartSessionMiddleware;
use Youtube\Controller\VisitsController;

$app->add(StartSessionMiddleware::class);

$app->get('/', HomeController::class . ':apply')->setName('home') ->add(BeforeMiddleware::class);

$app->get( '/visits', VisitsController::class . ":showVisits")->setName('visits');