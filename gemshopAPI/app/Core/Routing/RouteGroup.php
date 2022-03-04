<?php

namespace GemShopAPI\App\Core\Routing;

use Attribute;
use GemShopAPI\App\Middleware;

#[Attribute(\Attribute::TARGET_CLASS)]
class RouteGroup
{
    /**
     * @param string $group
     * @param array<Middleware> $middleware
     */
    public function __construct(string $group, array $middleware)
    {
        $middleware  = Middleware::Auth;
    }
}