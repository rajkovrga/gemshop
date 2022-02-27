<?php
require_once __DIR__ . '/../vendor/autoload.php';

<<<<<<< HEAD

var_dump("Pera");

//use DI\Bridge\Slim\Bridge;
//use GemShop\App\Core\DILoader;
//use GemShopApi\App\Core\EnvLoader;
//use GemShopAPI\App\Kernel;
//
//(new EnvLoader())->load();
//
//$containers = (new DILoader())->load();
//
//$app = Bridge::create();
//
//(new Kernel($app))->routes()->run();
//
=======
use DI\Bridge\Slim\Bridge;
use GemShop\App\Core\DILoader;
use GemShopApi\App\Core\EnvLoader;
use GemShopAPI\App\Kernel;


(new EnvLoader())->load();

$containers = (new DILoader())->load();

$app = Bridge::create();

(new Kernel($app))
    ->setup()
    ->run();
>>>>>>> b0962409af342fb5ee92b8b7cf0ad9f6f813736c

