<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get(
    '/',
    function (Request $request, Response $response) {
        return $this->get('view')->render($response, 'home.twig', []);
    }
)->setName('home');