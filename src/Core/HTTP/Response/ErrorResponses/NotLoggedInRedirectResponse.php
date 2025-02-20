<?php

namespace app\Core\HTTP\Response\ErrorResponses;
use app\Core\HTTP\Response\RedirectResponse;
use app\Enum\LoginStatus;

class NotLoggedInRedirectResponse extends RedirectResponse
{
    public function __construct()
    {
        parent::__construct('/login', ['loginStatus' =>LoginStatus::notLoggedIn->value]);
    }
}