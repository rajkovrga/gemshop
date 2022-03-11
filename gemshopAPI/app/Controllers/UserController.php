<?php

namespace GemShopAPI\App\Controllers;

use GemShopAPI\App\Core\Routing\GetMethod;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UserController
{
    #[GetMethod('/{id}')]
    public function getUser(Request $request, Response $response): Response
    {
        var_dump("DOMACIN");

        return $response->withStatus(202);
    }

}