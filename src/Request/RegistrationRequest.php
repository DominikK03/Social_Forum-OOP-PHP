<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;

#[AllowDynamicProperties]
class RegistrationRequest extends Request implements RequestInterface
{
    private string $name;
    private string $email;
    private string $password;
    private string $confirmPassword;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function fromRequest()
    {
        if ($this->request->getMethod() == "POST") {
            $this->name = htmlspecialchars($this->request->getRequestParam('name'));
            $this->email = htmlspecialchars($this->request->getRequestParam('email'));
            $this->password = htmlspecialchars($this->request->getRequestParam('password'));
            $this->confirmPassword = htmlspecialchars($this->request->getRequestParam('confirmPassword'));
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
    public function getEmail(): string
    {
        return $this->email;
    }
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    /**
     * @return string
     */
    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }
}