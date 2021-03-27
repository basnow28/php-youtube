<?php
declare(strict_types=1);

use SallePW\SlimApp\Controller\HomeController;

$app->get('/', HomeController::class . ':apply')->setName('home');