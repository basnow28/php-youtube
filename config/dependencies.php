<?php
declare(strict_types=1);

use DI\Container;
use Youtube\Controller\HomeController;
use Psr\Container\ContainerInterface;

$container = new Container();

$container->set(
    HomeController::class,
    function (ContainerInterface $c) {
        $controller = new HomeController($c->get("view"));
        return $controller;
    }
);