<?php
declare(strict_types=1);

use DI\Container;
use Slim\Views\Twig;
use PSr\Container\ContainerInterface;
use Youtube\Controller\CreateUserController;
use Youtube\Controller\HomeController;
use Youtube\Controller\VisitsController;
use Youtube\Controller\CookieMonsterController;

use Slim\Flash\Messages;
use Youtube\Controller\FlashController;
use Youtube\Repository\MysqlUserRepository;
use Youtube\Repository\PDOSingleton;
use Youtube\Controller\LoginUserController;
use Youtube\Controller\YoutubeVideosController;
use Youtube\Repository\MysqlSearchRepository;

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
        $controller = new HomeController($c->get("view"), $c->get("flash"));
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

$container->set(
    CookieMonsterController::class,
    function (ContainerInterface $c) {
        $controller = new CookieMonsterController($c->get("view"));
        return $controller;
    }
);


$container->set(
    'flash',
    function () {
        return new Messages();
    }
);

$container->set(
    FlashController::class,
    function (Container $c) {
        $controller = new FlashController($c->get("view"), $c->get("flash"));
        return $controller;
    }
);

$container->set('db', function () {
    return PDOSingleton::getInstance(
        $_ENV['MYSQL_USER'],
        $_ENV['MYSQL_ROOT_PASSWORD'],
        $_ENV['MYSQL_HOST'],
        $_ENV['MYSQL_PORT'],
        $_ENV['MYSQL_DATABASE']
    );
});

$container->set(UserRepository::class, function (ContainerInterface $container) {
    return new MysqlUserRepository($container->get('db'));
});

$container->set(
    CreateUserController::class,
    function (Container $c) {
        //LAST LINE OF EXECUTION
        $controller = new CreateUserController($c->get("view"), $c->get(UserRepository::class));
        return $controller;
    }
);

$container->set(
    LoginUserController::class,
    function (Container $c) {
        //LAST LINE OF EXECUTION
        $controller = new LoginUserController($c->get("view"), $c->get(UserRepository::class));
        return $controller;
    }
);

$container->set(MysqlSearchRepository::class, function (ContainerInterface $container) {
    return new MysqlSearchRepository($container->get('db'));
});

$container->set(
    YoutubeVideosController::class,
    function (Container $c) {
        //LAST LINE OF EXECUTION
        $controller = new YoutubeVideosController($c->get("view"), $c->get(MysqlSearchRepository::class));
        return $controller;
    }
);