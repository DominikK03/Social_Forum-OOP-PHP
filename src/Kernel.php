<?php

namespace app;

use AllowDynamicProperties;
use app\Core\DI\Container;
use app\Core\HTTP\Exception\RouteNotFoundException;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Response\ErrorResponses\PageNotFoundResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Core\HTTP\Router;
use app\Util\TemplateRenderer;
use app\View\error\PageNotFoundView;
use ReflectionMethod;

#[AllowDynamicProperties]
class Kernel
{
    public function __construct(protected Container $container, protected RequestValidator $validator)
    {
    }

    public function handle(Request $request): ResponseInterface
    {
        try {
            $routeData = $this->container->get(Router::class)->resolve($request);
            $controller = $this->container->get($routeData->getController());
            $controllerMethod = $routeData->getMethod();
            if ($request->getSession('user') !== null) {
                $this->authorize($routeData);
            }
            $dedicatedRequest = $this->provideRequest($controller, $controllerMethod, $request);
            return $controller->$controllerMethod($dedicatedRequest);

        } catch (RouteNotFoundException) {
            $pageNotFoundView = new PageNotFoundView($this->container->get(TemplateRenderer::class));
            return new PageNotFoundResponse(
                $pageNotFoundView->renderWithRenderer($this->container->get(TemplateRenderer::class)));
        }
    }

    private function authorize($routeData)
    {
        if ($this->validator->hasAccessToRoute($routeData->getRoles())) {
            return;
        }
        die("Access denied: You do not have the required role to access this route.");
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

                if (method_exists($dedicatedRequest, 'fromPostRequest') && $_SERVER['REQUEST_METHOD'] === 'POST') {
                    $dedicatedRequest->fromPostRequest();
                } elseif (method_exists($dedicatedRequest, 'fromGetRequest') && $_SERVER['REQUEST_METHOD'] === 'GET') {
                    $dedicatedRequest->fromGetRequest();
                }

                return $dedicatedRequest;
            }
        }

        return $request;
    }
}
