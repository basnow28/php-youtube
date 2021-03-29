<?php

declare(strict_types=1);

namespace Youtube\Controller;

use Exception;
use Slim\Routing\RouteContext;
use Youtube\Model\User;
use Youtube\Service\UserService;
use Slim\Views\Twig;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use DateTime;

final class CreateUserController
{

    private Twig $twig;
    private UserService $userService;
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    public function __construct(Twig $twig, UserService $userService)
    {
        $this->twig = $twig;
        $this->userService = $userService;
    }

    public function showRegistrationForm(Request $request, Response $response): Response
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        return $this->twig->render(
            $response,
            'register.twig',
            [
                'formAction' => $routeParser->urlFor("create_user"),
                'formMethod' => "POST"
            ]
        );
    }


    public function apply(Request $request, Response $response): Response
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        try {
            $data = $request->getParsedBody();

            // TODO - Validate data before instantiating the user
            $created_at = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));


            $user = new User(
                $data['email'] ?? '',
                $data['password'] ?? '',
                $created_at ?? ''
            );

            $id = $this->userService->save($user);
            if ($id == -1) {
                return $this->twig->render(
                    $response,
                    'register.twig',
                    [
                        'formAction' => $routeParser->urlFor("create_user"),
                        'formMethod' => "POST",
                        'errorMessage' => "The email is already in use"
                    ]
                );
            }

            $_SESSION['user_id'] = $id;
        } catch (Exception $exception) {
            // You could render a .twig template here to show the error
            $response->getBody()
                ->write('Unexpected error: ' . $exception->getMessage());
            return $response->withStatus(500);
        }

        return $response
            ->withHeader('Location', $routeParser->urlFor("search"))
            ->withStatus(302);
    }
}
