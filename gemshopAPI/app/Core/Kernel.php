<?php

namespace GemShopAPI\App\Core;

use Slim\App;

class Kernel
{
    protected App $app;

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

        return $this;
    }

    public function run(): void
    {
        $this->setup();
        $this->app->run();
    }
}