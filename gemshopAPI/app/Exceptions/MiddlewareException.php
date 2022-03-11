<?php

namespace GemShopAPI\App\Exceptions;

use Throwable;

class MiddlewareException extends \Exception
{

    public function __construct($message = "Middleware not found in Kernel", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}