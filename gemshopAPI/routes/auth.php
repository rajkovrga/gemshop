<?php

declare(strict_types=1);

use Slim\Routing\RouteCollectorProxy;

/**
    * @var $routes RouteCollectorProxy
 */

$routes->group('auth', function (RouteCollectorProxy $r)
{
     $r->post('/login', [AuthController::class, 'login']);

});
