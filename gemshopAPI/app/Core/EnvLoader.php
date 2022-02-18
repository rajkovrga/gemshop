<?php

namespace GemShopApi\App\Core;

use Dotenv\Dotenv;

class EnvLoader
{
    public function load($path = '/configurations'): void
    {
        $path = __DIR__ . $path;
        $files = array_diff(scandir($path), ['..', '.']);

        foreach ($files as $file) {
            Dotenv::createImmutable($path, $file);
        }
    }
}