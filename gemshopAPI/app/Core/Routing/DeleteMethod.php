<?php

namespace GemShopAPI\App\Core\Routing;

use Attribute;

#[Attribute(\Attribute::TARGET_METHOD)]
class DeleteMethod
{

    public function __construct(string $path, array $middlewares = [])
    {
    }
}