<?php

namespace GemShopAPI\App\Exceptions;

use GemShopAPI\App\Core\ErrorHandler;

class Handler extends ErrorHandler
{

    protected array $exceptions = [
        AuthException::class => 401,
    ];

}