<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\Bridge\Slim\Bridge;
use GemShopAPI\App\Core\DILoader;
use GemShopAPI\App\Core\EnvLoader;
use GemShopAPI\App\Kernel;

(new EnvLoader())->load();

    $containers = (new DILoader())->load();

$app = Bridge::create($containers);

    (new Kernel($app, $containers))->routes()->run();

