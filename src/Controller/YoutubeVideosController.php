<?php
declare(strict_types=1);

namespace Youtube\Controller;

use Exception;
use Slim\Routing\RouteContext;
use Youtube\Middleware\StartSessionMiddleware;
use Youtube\Model\User;
use Youtube\Model\UserLogin;
use Youtube\Service\UserService;
use Slim\Views\Twig;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use DateTime;

final class YoutubeVideosController
{

    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function showSearchForm(Request $request, Response $response): Response
    {

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        return $this->twig->render(
            $response,
            'search.twig',
            [
                'formAction' => $routeParser->urlFor("search"),
                'formMethod' => "GET"
            ]
        );
    }
}