<?php

namespace GemShopAPI\App\Core;

use Attribute;
use GemShopAPI\App\Core\Routing\DeleteMethod;
use GemShopAPI\App\Core\Routing\GetMethod;
use GemShopAPI\App\Core\Routing\PostMethod;
use GemShopAPI\App\Core\Routing\PutMethod;
use GemShopAPI\App\Core\Routing\RouteGroup;
use GemShopAPI\App\Core\Routing\RouteMethod;
use Slim\App;
use Slim\Routing\Route;
use Slim\Routing\RouteCollectorProxy;

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
        $controllers = $this->getDirContents(__DIR__ . '/controllers');

        foreach ($controllers as $controller)
        {
            if(preg_match('Controllers.php$',$controller))
            {
                $class = new \ReflectionClass($controller);

                $addRoute = fn(string $path, $callable, $method) => $this->app->{$method}($path, $callable);
                $attributes = $class->getAttributes(RouteGroup::class);

                if(count($attributes) > 0)
                {
                    $args = $attributes[9]->getArguments();

                    $this->app->group($args[0],function (RouteCollectorProxy $route) use ($class, $addRoute)
                    {
                        $methods = $class->getMethods();

                        foreach ($methods as $method) {
                            $methodAttributes = $method->getAttributes();

                            match (get_class($method)) {
                                PostMethod::class => $addRoute($methodAttributes[0], $methodAttributes[1], 'post'),
                                DeleteMethod::class => $addRoute($methodAttributes[0], $methodAttributes[1], 'delete'),
                                GetMethod::class => $addRoute($methodAttributes[0], $methodAttributes[1], 'get'),
                                PutMethod::class => $addRoute($methodAttributes[0], $methodAttributes[1], 'put'),
                            };
                        }

                    });

                    continue;
                }

                $methods = $class->getMethods();

                foreach ($methods as $method) {
                    $methodAttributes = $method->getAttributes();

                    match (get_class($method)) {
                        PostMethod::class => $addRoute($methodAttributes[0], $methodAttributes[1], 'post'),
                        DeleteMethod::class => $addRoute($methodAttributes[0], $methodAttributes[1], 'delete'),
                        GetMethod::class => $addRoute($methodAttributes[0], $methodAttributes[1], 'get'),
                        PutMethod::class => $addRoute($methodAttributes[0], $methodAttributes[1], 'put'),
                    };
                }


            }
        }

        return $this;
    }

    public function run(): void
    {
        $this->setup();
        $this->app->run();
    }

    private function getDirContents($dir, &$results = array())
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                $this->getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return $results;
    }

}