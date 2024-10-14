<?php

namespace app;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;
use app\Enum\Role;
use app\Model\User;

#[AllowDynamicProperties] class RequestValidator
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function hasAccessToRoute(array $roles) : bool
    {
        return in_array($this->request->getSessionParam('user', 'role'), $roles);
    }

    public function hasAccessToResource(string $resourceOwnerID) : bool
    {
        return $this->request->getSessionParam('user', 'userid') == $resourceOwnerID;
    }
}