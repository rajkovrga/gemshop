<?php
require_once __DIR__ . '/../vendor/autoload.php';

use GemShop\App\Contract\Core\ConfigLoader;
use GemShop\App\Core\EnvLoader;


(new EnvLoader())->load();

