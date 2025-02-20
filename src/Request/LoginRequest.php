<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;

#[AllowDynamicProperties]
class LoginRequest extends Request implements RequestInterface
{
    private string $name;
    private string $password;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function fromRequest()
    {
        if ($this->request->getMethod() == "POST") {
            $this->name = $this->request->getRequestParam('name');
            $this->password = $this->request->getRequestParam('password');
        }
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