<?php

namespace app\Core\HTTP;

class RouteData
{
    private string $controller;
    private string $method;

    public function __construct(string $controller, string $method)
    {
        $this->controller = $controller;
        $this->method = $method;
    }

    public function getController()
    {
        return $this->controller;
    }
    public function getMethod()
    {
        return $this->method;
    }
}