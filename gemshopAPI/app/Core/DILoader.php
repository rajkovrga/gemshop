<?php

declare(strict_types=1);

namespace GemShop\App\Core;

use DI\ContainerBuilder;
use JetBrains\PhpStorm\Pure;
use Psr\Container\ContainerInterface;
use Exception;

class DILoader
{

    private ContainerBuilder $builder;

    public function getAllDefinitions($path = '/di'): array
    {
        $files = scandir($path);
        $defs = [];
        foreach ($files as $file) {
            if(preg_match('\.php$', $file))
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
    public function load(): ContainerInterface
    {
        $this->builder = new ContainerBuilder();

        $this->builder->useAutowiring(true);

        $defs = $this->getAllDefinitions();
        return $this->builder->addDefinitions($defs)->build();
    }
}