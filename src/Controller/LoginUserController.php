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

final class LoginUserController
{

    private Twig $twig;
    private UserService $userService;
    private StartSessionMiddleware $startSessionMiddleware;

    public function __construct(Twig $twig, UserService $userService)
    {
        $this->twig = $twig;
        $this->userService = $userService;
    }

    public function showLoginForm(Request $request, Response $response): Response
    {

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        return $this->twig->render(
            $response,
            'login.twig',
            [
                'formAction' => $routeParser->urlFor("login_form"),
                'formMethod' => "POST"
            ]
        );
    }


    public function login(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();

            // TODO - Validate data before instantiating the user

            $user = new UserLogin(
                $data['email'] ?? '',
                $data['password'] ?? ''
            );

            $id = $this->userService->login($user);
        } catch (Exception $exception) {
            // You could render a .twig template here to show the error
            $response->getBody()
                ->write('The user doesnt exist in the database: ' . $exception->getMessage());
            return $response->withStatus(500);
        }

        if($id > 0){
            $_SESSION['user_id'] = $id;

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();

            return $response
                ->withHeader('Location', $routeParser->urlFor("search"))
                ->withStatus(302);
        }

        return $response->withStatus(200);
    }
}