<?php

namespace app\Core\HTTP\Response\ErrorResponses;
use app\Core\HTTP\Response\RedirectResponse;
use app\Enum\LoginStatus;

class LogoutRedirectResponse extends RedirectResponse
{
    public function __construct()
    {
        parent::__construct('/login', ['loginStatus' => LoginStatus::logOut->value]);
    }
}