<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DI\Bridge\Slim\Bridge;
use GemShop\App\Core\DILoader;
use GemShopApi\App\Core\EnvLoader;
use GemShopAPI\App\Kernel;


(new EnvLoader())->load();

$containers = (new DILoader())->load();

$app = Bridge::create();

(new Kernel($app))->routes()->run();


