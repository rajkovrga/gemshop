<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\Bridge\Slim\Bridge;
use GemShopAPI\App\Core\DILoader;
use GemShopAPI\App\Core\EnvLoader;
use GemShopAPI\App\Kernel;

(new EnvLoader())->load();

try {
    $containers = (new DILoader())->load();
} catch (Exception $e) {
}

$app = Bridge::create($containers);

try {
    (new Kernel($app))->routes()->run();
} catch (Throwable $e) {
    var_dump($e);
}

