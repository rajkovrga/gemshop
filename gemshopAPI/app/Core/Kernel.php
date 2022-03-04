<?php

namespace GemShopAPI\App\Core;

use GemShopAPI\App\Core\Routing\{DeleteMethod, GetMethod, PostMethod, PutMethod, RouteGroup};
use ReflectionClass;
use ReflectionException;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class Kernel
{
    protected array $middlewares = [];
    private App $app;
    private array $routes;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * @throws ReflectionException
     */
    public function routes(): Kernel
    {
        $controllers = $this->getDirContents(__DIR__ . '/../Controllers');
        foreach ($controllers as $controller) {
            if (preg_match('/Controller.php$/', $controller)) {
                $controller = substr($controller, 0, -4);
                $namespace = $_ENV['NAMESPACE'] . str_replace('/', '\\', explode('app/', $controller)[1]);
                $class = new ReflectionClass(
                    $namespace
                );

                $addRoute = static fn($group, string $path, $callable, $method) => $group->{$method}($path, $callable);
                $attributes = $class->getAttributes(RouteGroup::class);

                if (count($attributes) > 0) {
                    $args = $attributes[0]->getArguments();
                    $this->app->group($args[0], function (RouteCollectorProxy $group) use ($namespace, $addRoute, $class) {
                        $methods = $class->getMethods();

                        foreach ($methods as $method) {
                            $attributes = $method->getAttributes();
                            foreach ($attributes as $attribute) {
                                match ($attribute->getName()) {
                                    PostMethod::class => $addRoute(
                                        $group,
                                        $attribute->getArguments()[0],
                                        [$namespace, $method->getName()],
                                        'post'
                                    ),
                                    DeleteMethod::class => $addRoute(
                                        $group,
                                        $attribute->getArguments()[0],
                                        [$namespace, $method->getName()],
                                        'delete'
                                    ),
                                    GetMethod::class => $addRoute(
                                        $group,
                                        $attribute->getArguments()[0],
                                        [$namespace, $method->getName()],
                                        'get'
                                    ),
                                    PutMethod::class => $addRoute(
                                        $group,
                                        $attribute->getArguments()[0],
                                        [$namespace, $method->getName()],
                                        'put'
                                    ),
                                };
                            }
                        }
                    });

                    return $this;
                }
            }
        }

        return $this;
    }

    /**
     * @param string $dir
     * @param array $results
     *
     * @return array
     */
    private function getDirContents(string $dir, array &$results = []): array
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else {
                if ($value !== "." && $value !== "..") {
                    $this->getDirContents($path, $results);
                    $results[] = $path;
                }
            }
        }

        return $results;
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

        return $this;
    }

}