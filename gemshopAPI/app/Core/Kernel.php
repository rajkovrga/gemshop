<?php

namespace GemShopAPI\App\Core;

use Slim\App;

class Kernel
{
    private App $app;
    private array $routes;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    protected $middlewares = [];

    public function setup(): static
    {
        return $this;
    }

    public function routes(): Kernel
    {
        $path = __DIR__ . '/di';
        $files = array_diff(scandir($path), ['..', '.']);

        foreach ($files as $file)
        {
            $req = require $path . '/' . $file;
            $defs = array_merge($defs, $req);
        }

        return $this;
    }

    public function run(): void
    {
        $this->setup();
        $this->app->run();
    }
}