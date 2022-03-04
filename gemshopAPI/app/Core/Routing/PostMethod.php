<?php

namespace GemShopAPI\App\Core\Routing;

use Attribute;

#[Attribute(\Attribute::TARGET_METHOD)]
class PostMethod
{
    public function __construct(string $path)
    {
    }
}