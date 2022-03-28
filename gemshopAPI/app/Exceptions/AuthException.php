<?php

namespace GemShopAPI\App\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

class AuthException extends \Exception
{
    #[Pure] public function __construct(string $message = "User is not authorized", int $code = 401, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}