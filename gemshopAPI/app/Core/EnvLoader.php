<?php

namespace GemShop\App\Core;

use Dotenv\Dotenv;
use GemShop\App\Contract\Core\ConfigLoader;
use function PHPUnit\Framework\throwException;

class EnvLoader extends ConfigLoader
{
    protected function load(): void
    {
        $files = array_diff(scandir(__DIR__ . '/configurations'), ['..', '.']);

        foreach ($files as $file) {
            Dotenv::createImmutable(__DIR__ . '/configurations', $file);
        }
        
    }
}