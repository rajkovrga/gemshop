<?php

use GemShop\App\Contract\Core\ConfigLoader;
use GemShop\App\Core\EnvLoader;

require_once __DIR__ . '/../vendor/autoload.php';

(new EnvLoader())->load();

