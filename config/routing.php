<?php
declare(strict_types=1);

use Youtube\Controller\CookieMonsterController;
use Youtube\Controller\CreateUserController;
use Youtube\Controller\FlashController;
use Youtube\Controller\HomeController;
use Youtube\Middleware\BeforeMiddleware;
use Youtube\Middleware\StartSessionMiddleware;
use Youtube\Controller\VisitsController;
use Youtube\Controller\LoginUserController;
use Youtube\Controller\YoutubeVideosController;

$app->add(StartSessionMiddleware::class);

$app->get('/', HomeController::class . ':apply')->setName('home');

$app->get( '/visits', VisitsController::class . ":showVisits")->setName('visits');

$app->get('/cookies', CookieMonsterController::class . ":showAdvice")->setName('advice');

$app->get('/flash', FlashController::class . ":addMessage")->setName('flash');

$app->post(
    '/users',
    CreateUserController::class . ":apply"
)->setName('create_user');

$app->get(
    '/register',
    CreateUserController::class . ":showRegistrationForm"
)->setName('registration_form');

$app->post(
    '/login',
    LoginUserController::class . ":login"
)->setName('login_user');

$app->get(
    '/login',
    LoginUserController::class . ":showLoginForm"
)->setName('login_form');

$app->get(
    '/search',
    YoutubeVideosController::class . ":showSearchForm"
)->setName('search');

$app->get(
    '/search/videos',
    YoutubeVideosController::class . ":searchForVideos"
)->setName('search_videos');

$app->get(
    '/logout',
    LoginUserController::class . ":logout"
)->setName('logout_user');