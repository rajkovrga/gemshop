<?php
declare(strict_types=1);

namespace GemShopAPI\App\Core;

use Dotenv\Dotenv;

class EnvLoader
{
    public function load($path = __DIR__ . '/../../configurations'): void
    {
        $files = array_diff(scandir($path), ['..', '.']);
        $dotenv = Dotenv::createUnsafeMutable($path, $files);
        $dotenv->load();
    }
}