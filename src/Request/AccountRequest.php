<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;

#[AllowDynamicProperties] class AccountRequest
{
    private string $name;
    private string $password;
    private string $newPassword;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function fromRequest()
    {
        $this->name = $_SESSION['user']['username'];
        $this->password = $this->request->getRequestParam('currentPassword');
        $this->newPassword = $this->request->getRequestParam('newPassword');
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

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

}