<?php

namespace app\Core\HTTP;

use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Exception\RouteNotFoundException;
use app\Core\HTTP\Request\Request;
use ReflectionClass;
use ReflectionException;


final class Router
{
    private array $routes = [];

    public function __construct()
    {
    }

    /**
     * @throws ReflectionException
     */
    public function registerControllers(array $controllers)
    {
        foreach ($controllers as $controller) {
            $reflectionController = new ReflectionClass($controller);


            foreach ($reflectionController->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();
                    $this->register($route->method, $route->routePath, $controller, $method->getName());
                }
            }
        }
    }

    public function register(string $requestMethod, string $path, string $controller, string $controllerMethod): self
    {
        $this->routes[$requestMethod][$path] = new RouteData($controller, $controllerMethod);

        return $this;
    }


    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * @throws RouteNotFoundException
     */
    public function resolve(Request $request)
    {
        $path = explode('?', $request->getPath())[0];

        return $this->routes[$request->getMethod()][$path] ?? throw new RouteNotFoundException();
    }


}