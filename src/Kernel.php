<?php

namespace app;

use AllowDynamicProperties;
use app\Core\DI\Container;
use app\Core\HTTP\Exception\RouteNotFoundException;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Request\RequestValidator;
use app\Core\HTTP\Response\ErrorResponses\AccessDeniedResponse;
use app\Core\HTTP\Response\ErrorResponses\PageNotFoundResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Core\HTTP\Router;
use app\Exception\AccessDeniedException;
use app\Model\User;
use app\Util\TemplateRenderer;
use app\View\error\AccessDeniedView;
use app\View\error\PageNotFoundView;
use app\View\ViewFactory;
use ReflectionMethod;

const FROM_REQUEST = 'fromRequest';
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
            if ($request->getSession(User::USER) !== null) {
                $this->authorize($request, $routeData);
            }

            $dedicatedRequest = $this->provideRequest($controller, $controllerMethod, $request);
            return $controller->$controllerMethod($dedicatedRequest);
        } catch (RouteNotFoundException) {
            return new PageNotFoundResponse(
                ViewFactory::create404ResponseView()->renderWithRenderer($this->container->get(TemplateRenderer::class))
            );
        } catch (AccessDeniedException) {
            return new AccessDeniedResponse(
                ViewFactory::create401ResponseView()->renderWithRenderer($this->container->get(TemplateRenderer::class))
            );
        }
    }

    private function authorize(Request $request, $routeData)
    {
        RequestValidator::validate($request,$routeData->getRoles());
    }

    /**
     * @throws \ReflectionException
     */
    private function provideRequest(object $controller, string $methodName, Request $request)
    {
        $reflectionMethod = new ReflectionMethod($controller, $methodName);
        $parameters = $reflectionMethod->getParameters();

        foreach ($parameters as $param) {
            $paramType = $param->getType();
            if ($paramType && class_exists($paramType->getName())) {
                $dedicatedRequestClass = $paramType->getName();
                $dedicatedRequest = new $dedicatedRequestClass($request);

                if (method_exists($dedicatedRequest, FROM_REQUEST)) {
                    $dedicatedRequest->fromRequest();
                }

                return $dedicatedRequest;
            }
        }

        return $request;
    }

    public function sendResponse(ResponseInterface $response): void
    {
        header($response->getContentType()->value);
        http_response_code($response->getStatusCode());
        echo $response->getContent();
    }
}
