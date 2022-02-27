<?php
declare(strict_types=1);

namespace GemShopAPI\App\Core;

use Dotenv\Dotenv;

class EnvLoader
{
    public function load($path = __DIR__ . '/configurations'): void
    {
        $files = array_diff(scandir($path), ['..', '.']);
<<<<<<< HEAD
        var_dump($path);
            $dotenv = Dotenv::createMutable([$path], $files);
            $dotenv->load();
=======

        $dotenv = Dotenv::createMutable([$path], $files);
        $dotenv->load();
>>>>>>> b0962409af342fb5ee92b8b7cf0ad9f6f813736c
    }
}