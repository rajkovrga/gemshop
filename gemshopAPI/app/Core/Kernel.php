<?php

namespace GemShopAPI\App\Core;

use GemShopAPI\App\Core\Routing\{DeleteMethod, GetMethod, PostMethod, PutMethod, RouteGroup};
use GemShopAPI\App\Exceptions\MiddlewareException;
use {ReflectionClass, ReflectionException};
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class Kernel
{
    protected array $middlewares = [];
    protected array $globalMiddlewares = [];

    public function __construct(private readonly App $app) {}

    /**
     * @throws ReflectionException
     * @throws MiddlewareException
     */
    public function routes(): Kernel
    {
        var_dump(dirname(__DIR__));
        var_dump(dirname(__DIR__, 2));
        $controllers = $this->getDirContents(__DIR__ . '/../Controllers');
        foreach ($controllers as $controller) {
            if (preg_match('/Controller.php$/', $controller)) {
                $controller = substr($controller, 0, -4);
                $namespace = $_ENV['NAMESPACE'] . str_replace('/', '\\', explode('app/', $controller)[1]);
                $class = new ReflectionClass(
                    $namespace
                );

                $attributes = $class->getAttributes(RouteGroup::class);

                $methods = $class->getMethods();

                if (count($attributes) > 0) {
                    $args = $attributes[0]->getArguments();

                    if(!empty($args[1]))
                    {
                        $this->app->group($args[0], fn(RouteCollectorProxy $group) => $this->registerRoute($methods, $namespace, $group))->add($args[1]);

                        continue;
                    }

                    $this->app->group($args[0], fn(RouteCollectorProxy $group) => $this->registerRoute($methods, $namespace, $group))->add($args[1]);

                    continue;
                }

                $this->registerRoute($methods, $namespace, $this->app);
            }
        }

        return $this;
    }

    private function getDirContents(string $dir, array &$results = []): array
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } elseif ($value !== "." && $value !== "..") {
                $this->getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return $results;
    }

    /**
     * @throws MiddlewareException
     */
    private function registerRoute(array $methods,string $namespace,RouteCollectorProxy $group): void
    {
        if(!empty($middleware))
        {
            if(empty($this->middlewares[$middleware]) || !isset($this->middlewares[$middleware]))
            {
                throw new MiddlewareException("Middleware not found in Kernel", 500);
            }

            $middleware = $this->middlewares[$middleware];
        }

        $addRoute = static fn(RouteCollectorProxy $group, string $path,array $callable,string $method,string $middleware = '') => $group->put($path, $callable)->add($middleware);

        foreach ($methods as $method) {
            $attributes = $method->getAttributes();
            foreach ($attributes as $attribute) {
                match ($attribute->getName()) {
                    PostMethod::class => $addRoute(
                        $group,
                        $attribute->getArguments()[0],
                        [$namespace, $method->getName()],
                        'post',
                        $middleware
                    ),
                    DeleteMethod::class => $addRoute(
                        $group,
                        $attribute->getArguments()[0],
                        [$namespace, $method->getName()],
                        'delete',
                        $middleware
                    ),
                    GetMethod::class => $addRoute(
                        $group,
                        $attribute->getArguments()[0],
                        [$namespace, $method->getName()],
                        'get',
                        $middleware
                    ),
                    PutMethod::class => $addRoute(
                        $group,
                        $attribute->getArguments()[0],
                        [$namespace, $method->getName()],
                        'put',
                        $middleware
                    ),
                };
            }
        }

    }

    public function run(): void
    {
        $this->setup();
        $this->app->run();
    }

    public function setup(): static
    {
        $this->app->addRoutingMiddleware();
        $this->app->addBodyParsingMiddleware();

        if(!empty($this->globalMiddlewares))
        {
            foreach ($this->globalMiddlewares as $m)
            {
                $this->app->add($m);
            }
        }

        return $this;
    }

}