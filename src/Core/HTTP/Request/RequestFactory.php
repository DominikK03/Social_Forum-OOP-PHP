<?php

namespace app\Core\HTTP\Request;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class RequestFactory
{
    public function __construct(RequestValidator $validator)
    {
        $this->requestValidator = $validator;
    }
    public static function createFromGlobals(): Request
    {
        return new Request(
            $_SERVER['REQUEST_URI'] ?? '/',
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            $_POST ?? [],
            $_GET ?? [],
            $_FILES ?? [],
            $_SESSION ?? []
        );
    }
}
