<?php

namespace app\Core\HTTP;
class RouteData
{
    private string $controller;
    private string $method;
    private array $roles;
    public function __construct(string $controller, string $method, array $roles = [])
    {
        $this->controller = $controller;
        $this->method = $method;
        $this->roles = $roles;
    }
    public function getController(): string
    {
        return $this->controller;
    }
    public function getMethod(): string
    {
        return $this->method;
    }
    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}