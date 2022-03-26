<?php

namespace GemShopAPI\App\Controllers;

use GemShopAPI\App\Core\Routing\GetMethod;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    #[GetMethod('/{id}')]
    public function getUser(Request $request, Response $response): Response
    {

        return $response->withStatus(202);
    }

}