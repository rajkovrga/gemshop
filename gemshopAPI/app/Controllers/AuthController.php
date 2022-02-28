<?php

namespace GemShopAPI\App\Controllers;

use GemShopAPI\App\Core\Routing\RouteGroup;
use GemShopAPI\App\Core\Routing\RouteMethod;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

#[RouteGroup('/auth','auth')]
class AuthController
{

    #[RouteMethod('/login')]
    public function login(Request $request, Response $response): Response
    {

        return $response;
    }
}