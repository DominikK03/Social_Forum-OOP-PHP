<?php

namespace app;

use AllowDynamicProperties;
use app\Core\DI\Container;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Exception\RouteNotFoundException;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Response\ErrorResponses\PageNotFoundResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Core\HTTP\Router;
use ReflectionMethod;

#[AllowDynamicProperties]
class Kernel
{
    public function __construct(protected Container $container)
    {
    }

    public function handle(Request $request): ResponseInterface
    {
        try {
            $routeData = $this->container->get(Router::class)->resolve($request);
            $controller = $this->container->get($routeData->getController());
            $controllerMethod = $routeData->getMethod();

            $dedicatedRequest = $this->provideRequest($controller, $controllerMethod, $request);

            return $controller->$controllerMethod($dedicatedRequest);

        } catch (RouteNotFoundException) {
           die();
        }
    }

    private function provideRequest(object $controller, string $methodName, Request $request)
    {
        $reflectionMethod = new ReflectionMethod($controller, $methodName);
        $parameters = $reflectionMethod->getParameters();

        foreach ($parameters as $param) {
            $paramType = $param->getType();
            if ($paramType && class_exists($paramType->getName())) {
                $dedicatedRequestClass = $paramType->getName();

                $dedicatedRequest = new $dedicatedRequestClass($request);

                if (method_exists($dedicatedRequest, 'fromRequest') && $_SERVER['REQUEST_METHOD']=== 'POST') {
                    $dedicatedRequest->fromRequest();
                }

                return $dedicatedRequest;
            }
        }

        return $request;
    }
}
