<?php

namespace GemShopAPI\App\Controllers;

use GemShopAPI\App\Core\Routing\{GetMethod, PostMethod, PutMethod};
use GemShopAPI\App\Core\Routing\RouteGroup;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

#[RouteGroup('/auth', ['auth'])]
class AuthController
{

    #[GetMethod('/login/{id}/{kt}')]
    public function login(Request $request, Response $response, $id): Response
    {
        return $response->withStatus(201);
    }

    #[PutMethod('/update/{id}')]
    public function update(Request $request, Response $response, $id): Response
    {

        return $response->withStatus(204);
    }
}