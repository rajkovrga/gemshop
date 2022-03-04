<?php

namespace GemShopAPI\App\Controllers;

use GemShopAPI\App\Core\Routing\{GetMethod, PostMethod, PutMethod};
use GemShopAPI\App\Core\Routing\RouteGroup;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

#[RouteGroup('/auth', [])]
class AuthController
{

    #[GetMethod('/login/:id')]
    public function login(Request $request, Response $response, $id): Response
    {
        echo "login" . $id;
        return $response->withStatus(202);
    }
}