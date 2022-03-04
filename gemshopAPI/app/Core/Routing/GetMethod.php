<?php

namespace GemShopAPI\App\Core\Routing;

use Attribute;

#[Attribute(\Attribute::TARGET_METHOD)]
class GetMethod
{

    public function __construct(string $path)
    {
    }
}

