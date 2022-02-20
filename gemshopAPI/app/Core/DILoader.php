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

        return [];
    }

    /**
     * @return ContainerInterface
     * @throws Exception
     */
    public function load(): ContainerInterface
    {

        $defs = $this->getAllDefinitions();
        return $this->builder->addDefinitions($defs)->build();
    }
}