<?php

namespace GemShopAPI\App;

use GemShopAPI\App\Middlewares\AuthMiddleware;

class Kernel extends Core\Kernel
{

    protected array $middlewares = [
        'auth' => AuthMiddleware::class
    ];

    protected array $globalMiddlewares = [
    ];

}