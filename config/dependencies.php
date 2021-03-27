<?php
declare(strict_types=1);

use DI\Container;
use Slim\Views\Twig;
use PSr\Container\ContainerInterface;
use Youtube\Controller\HomeController;
use Youtube\Controller\VisitsController;

$container = new Container();

$container->set(
    'view',
    function () {
        return Twig::create(__DIR__ . '/../templates', ['cache' => false]);
    }
);

$container->set(
    HomeController::class,
    function (ContainerInterface $c) {
        $controller = new HomeController($c->get("view"));
        return $controller;
    }
);

$container->set(
    VisitsController::class,
    function (ContainerInterface $c) {
        $controller = new VisitsController($c->get("view"));
        return $controller;
    }
);