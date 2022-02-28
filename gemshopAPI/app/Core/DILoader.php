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
<<<<<<< HEAD
        $files = scandir($path);
        $defs = [];
        foreach ($files as $file) {
            if(preg_match('\.php$', $file))
            {
                $data = require $path . '/' . $file;
                $defs = array_merge($defs, $data);
            }
=======
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
>>>>>>> b0962409af342fb5ee92b8b7cf0ad9f6f813736c
        }

        return $defs;
    }

    /**
     * @return ContainerInterface
     * @throws Exception
     */
    public function load(): ContainerInterface
    {
<<<<<<< HEAD
        $this->builder = new ContainerBuilder();

        $this->builder->useAutowiring(true);

=======
        $this->builder->useAnnotations(true);
        $this->builder->useAutowiring(true);
>>>>>>> b0962409af342fb5ee92b8b7cf0ad9f6f813736c
        $defs = $this->getAllDefinitions();
        return $this->builder->addDefinitions($defs)->build();
    }
}