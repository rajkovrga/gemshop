<?php

namespace GemShopAPI\Tests\E2E\Core;

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
        $this->envLoader->load(__DIR__ . '/data');

        $this->assertEquals('test_value', $_ENV['testt']);
    }
}