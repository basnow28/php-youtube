<?php

declare(strict_types=1);

namespace Youtube\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Flash\Messages;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

final class HomeController
{
    private Twig $twig;

    private Messages $flash;

    // You can also use https://stitcher.io/blog/constructor-promotion-in-php-8
    public function __construct(Twig $twig, Messages $flash)
    {
        $this->twig = $twig;
        $this->flash = $flash;
    }

    public function apply(Request $request, Response $response)
    {
        $messages = $this->flash->getMessages();

        if (isset($_SESSION['user_id'])) {
            if ($_SESSION['user_id'] == -1) {
                return $this->twig->render(
                    $response,
                    'home.twig'
                );
            }
        }
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $this->twig->render(
            $response,
            'search.twig',
            [
                'formAction' => $routeParser->urlFor("search_videos"),
                'formMethod' => "GET"
            ]
        );
    }
}
