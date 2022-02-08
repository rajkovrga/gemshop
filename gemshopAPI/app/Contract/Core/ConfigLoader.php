<?php

namespace GemShop\App\Contract\Core;

abstract class ConfigLoader
{
    protected abstract function load(): void;
}