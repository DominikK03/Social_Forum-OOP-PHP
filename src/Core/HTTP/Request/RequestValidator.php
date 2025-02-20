<?php

namespace app\Core\HTTP\Request;

use AllowDynamicProperties;
use app\Exception\AccessDeniedException;
use app\Model\User;

#[AllowDynamicProperties]
class RequestValidator
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function hasAccessToRoute(array $roles): bool
    {
        return in_array($this->request->getSessionParam(User::USER, USER::ROLE), $roles);
    }

    public static function validate(Request $request, array $roles)
    {
        if(!in_array($request->getSessionParam(User::USER, User::ROLE), $roles)){
            throw new AccessDeniedException();
        }
    }
}
