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
use GuzzleHttp as Guzzle;
use Youtube\Repository\My;
use Youtube\Model\Search;
use Youtube\Repository\MysqlSearchRepository;

use DateTime;

final class YoutubeVideosController
{

    private Twig $twig;
    private MysqlSearchRepository $mysqlSearchRepository;

    public function __construct(Twig $twig, MysqlSearchRepository $mysqlSearchRepository)
    {
        $this->twig = $twig;
        $this->mysqlSearchRepository = $mysqlSearchRepository;
    }

    public function showSearchForm(Request $request, Response $response): Response
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        if($_SESSION['user_id'] != null){
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
        return $this->twig->render(
            $response,
            'home.twig'
        );
    }

    public function searchForVideos(Request $request, Response $response): Response
    {
        //Getting videos with guzzle
        $data = $request->getQueryParams();
        $q = $data['videoTitle'];

        //Creating the request youtube url
        $requestUrl = $_ENV['YT_URL'] . '&q=' . $q . '&key=' . $_ENV['YT_API_KEY'];

        $client = new Guzzle\Client();
        try {
            $res = $client->request('GET', $requestUrl, [
                'auth' => ['user', 'pass']
            ]);
        } catch (Guzzle\Exception\GuzzleException $e) {
            echo $e;
        }

        //Save search to the search table
        $created_at = date_create_from_format('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        $this -> mysqlSearchRepository->save(new Search($_SESSION['user_id'], $q, $created_at));

        $items_body = (string) $res->getBody();
        $items_array = json_decode($items_body) -> items;

        $videos = array();

        foreach($items_array as $item){;
            $videoId = $item->id->videoId;
            $videoTitle= $item->snippet->title;
            $videoUrl = "https://www.youtube.com/watch?v=" . $videoId;

            array_push($videos, array("title" => $videoTitle, "url" => $videoUrl));
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        return $this->twig->render(
            $response,
            'search.twig',
            [
                'formAction' => $routeParser->urlFor("search_videos"),
                'formMethod' => "GET",
                'videos' => $videos
            ]
        );
    }

    private function saveSearchToTheTable(string $title):void{

    }
}