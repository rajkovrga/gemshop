<?php

declare(strict_types=1);

namespace GemShopAPI\App\Core;

use DI\Container;
use DI\ContainerBuilder;
use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerInterface;
use Exception;

class DILoader
{

    private ContainerBuilder $builder;

    public function getAllDefinitions($path = __DIR__ . '/../../di'): array
    {
        $files = scandir($path);
        $defs = [];
        foreach ($files as $file) {
            if(preg_match('/\.php$/', $file))
            {
                $data = require $path . '/' . $file;
                $defs = array_merge($defs, $data);
            }
        }

        return $defs;
    }

    /**
     * @return ContainerInterface
     * @throws Exception
     */
    public function load(): Container
    {
        $this->builder = new ContainerBuilder();

        $this->builder->useAnnotations(false);
        $this->builder->useAutowiring(true);
        $defs = $this->getAllDefinitions();
        return $this->builder->addDefinitions($defs)->build();
    }
}