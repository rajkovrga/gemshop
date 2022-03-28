<?php

namespace GemShopAPI\App\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

class MiddlewareException extends \Exception
{

    #[Pure] public function __construct($message = "Middleware not found in Kernel", $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}