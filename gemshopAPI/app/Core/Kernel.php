<?php

namespace GemShopAPI\App\Core;

use GemShopAPI\App\Core\Routing\{DeleteMethod, GetMethod, PostMethod, PutMethod, RouteGroup};
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use GemShopAPI\App\Exceptions\Handler;
use GemShopAPI\App\Exceptions\MiddlewareException;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use ReflectionException;
use Slim\App;
use Slim\Interfaces\RouteGroupInterface;
use Slim\Routing\Route;
use Slim\Routing\RouteCollectorProxy;

class Kernel
{
    protected array $middlewares = [];
    protected array $globalMiddlewares = [];

    public function __construct(
        private readonly App $app,
        private readonly Container $containers
    )
    {
    }

    /**
     * @throws ReflectionException
     * @throws MiddlewareException
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

                $attributes = $class->getAttributes(RouteGroup::class);

                $methods = $class->getMethods();

                if (count($attributes) > 0) {
                    $args = $attributes[0]->getArguments();

                    $group = $this->app->group(
                        $args[0],
                        fn(RouteCollectorProxy $group) => $this->registerRoute($methods, $namespace, $group)
                    );
                    $this->setMiddlewares($args[1] ?? [], $group);

                    continue;
                }

                $this->registerRoute($methods, $namespace, $this->app, $args[1] ?? []);
            }
        }

        return $this;
    }

    private function getDirContents(string $dir, array &$results = []): array
    {
        $files = scandir($dir);

        foreach ($files as $value) {
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
    private function registerRoute(
        array               $methods,
        string              $namespace,
        RouteCollectorProxy $group,
        array               $middlewares = []
    ): void
    {
        foreach ($methods as $method) {
            $attributes = $method->getAttributes();
            foreach ($attributes as $attribute) {
                $requestType = match ($attribute->getName()) {
                    PostMethod::class => 'post',
                    DeleteMethod::class => 'delete',
                    GetMethod::class => 'get',
                    PutMethod::class => 'put',
                };

                $grp = $group->{$requestType}($attribute->getArguments()[0], [$namespace, $method->getName()]);

                $this->setMiddlewares($middlewares, $grp);
            }
        }
    }

    /**
     * @throws MiddlewareException
     */
    private function setMiddlewares(array $middlewares, RouteGroupInterface|Route $group): void
    {
        foreach ($middlewares as $middleware) {
            if (empty($this->middlewares[$middleware]) || !isset($this->middlewares[$middleware])) {
                throw new MiddlewareException("Middleware not found in Kernel", 500);
            }
            $group->add($this->middlewares[$middleware]);
        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function run(): void
    {
        $this->setup($this->containers->get(Logger::class));
        $this->app->run();
    }

    public function setup(LoggerInterface $logger = null): static
    {
        $this->app->addRoutingMiddleware();
        $this->app->addBodyParsingMiddleware();

        $errorMiddleware = $this->app->addErrorMiddleware(
            true,
            true,
            true
        );

        $errorMiddleware->setDefaultErrorHandler(new Handler(
            $this->app->getCallableResolver(),
            $this->app->getResponseFactory(),
            $logger
        ));

        if (!empty($this->globalMiddlewares)) {
            foreach ($this->globalMiddlewares as $m) {
                $this->app->add($m);
            }
        }

        return $this;
    }

}