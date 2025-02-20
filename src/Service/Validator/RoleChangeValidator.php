<?php

namespace app\Service\Validator;

use app\Enum\Role;
use app\Exception\MasterRoleException;
use app\Exception\UserDoesntExistException;
use app\Util\StaticValidator;

class RoleChangeValidator
{
    /**
     * @throws MasterRoleException
     * @throws UserDoesntExistException
     */
    public function validateRoleChange(?object $user)
    {
        StaticValidator::assertNotNull($user);
        StaticValidator::assertNotEqual($user->getRole(), Role::master);
    }
}