<?php

namespace GemShopAPI\App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthMiddleware
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        $response = $next($request, $response);

        if ($request->getHeader(''))
        {

        }

        return $response;
    }
}