<?php
declare(strict_types=1);

namespace Youtube\Controller;

use Exception;
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
   

    public function apply(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();

            // TODO - Validate data before instantiating the user
            $created_at = date_create_from_format('Y-m-d H:i:s', $data['created_at']);

            $user = new User(
                $data['email'] ?? '',
                $data['password'] ?? '',
                $created_at ?? ''
            );

            $this->userService->save($user);
        } catch (Exception $exception) {
            // You could render a .twig template here to show the error
            $response->getBody()
                ->write('Unexpected error: ' . $exception->getMessage());
            return $response->withStatus(500);
        }

        return $response->withStatus(201);
    }
}