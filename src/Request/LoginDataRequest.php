<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;

#[AllowDynamicProperties] class LoginDataRequest extends Request
{
    private string $name;
    private string $password;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function fromRequest()
    {
        $this->name = $this->request->getRequestParam('name');
        $this->password = $this->request->getRequestParam('password');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}