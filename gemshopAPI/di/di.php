<?php

use DI\Container;
use GemShopAPI\App\Controllers\AuthController;

return [
    AuthController::class => static fn(Container $container) => new AuthController()

];