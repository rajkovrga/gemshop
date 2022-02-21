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

    #[Pure] public function __construct()
    {
        $this->builder = new ContainerBuilder();
    }

    public function getAllDefinitions(): array
    {
        $defs = [];
        $path = __DIR__ . '/di';
        $files = array_diff(scandir($path), ['.', '..']);

        foreach ($files as $file)
        {
            $req = require $path . '/' . $file;
            $defs = array_merge($defs, $req);
        }

        return $defs;
    }

    /**
     * @return ContainerInterface
     * @throws Exception
     */
    public function load(): ContainerInterface
    {
        $this->builder->useAnnotations(true);
        $this->builder->useAutowiring(true);
        $defs = $this->getAllDefinitions();
        return $this->builder->addDefinitions($defs)->build();
    }
}