<?php

namespace GemShopAPI\App\Core\Routing;

use Attribute;

#[Attribute(\Attribute::TARGET_CLASS)]
class RouteGroup
{

    /**
     * @param string $group
     * @param array $middlewares
     */
    public function __construct(string $group, array $middlewares = [])
    {
    }
}