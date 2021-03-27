<?php
declare(strict_types=1);

use Youtube\Controller\CookieMonsterController;
use Youtube\Controller\CreateUserController;
use Youtube\Controller\FlashController;
use Youtube\Controller\HomeController;
use Youtube\Middleware\BeforeMiddleware;
use Youtube\Middleware\StartSessionMiddleware;
use Youtube\Controller\VisitsController;

$app->add(StartSessionMiddleware::class);

$app->get('/', HomeController::class . ':apply')->setName('home') ->add(BeforeMiddleware::class);

$app->get( '/visits', VisitsController::class . ":showVisits")->setName('visits');

$app->get('/cookies', CookieMonsterController::class . ":showAdvice")->setName('advice');

$app->get('/flash', FlashController::class . ":addMessage")->setName('flash');

$app->post(
    '/users',
    CreateUserController::class . ":apply"
)->setName('create_user');