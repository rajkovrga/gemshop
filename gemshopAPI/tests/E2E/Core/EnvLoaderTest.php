<?php

namespace GemShopAPI\Tests\Core;

use GemShopAPI\App\Core\EnvLoader;
use PHPUnit\Framework\TestCase;

class EnvLoaderTest extends TestCase
{
    private EnvLoader $envLoader;
    protected function setUp(): void
    {
        $this->envLoader = new EnvLoader();
        parent::setUp();
    }

    public function test_load_config()
    {
        $this->envLoader->load('/data');

        $this->assertEquals('test_value', getenv('TEST') . 'aa');
    }
}