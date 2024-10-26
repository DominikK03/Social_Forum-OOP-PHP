<?php

namespace app\Service\Validator;

use app\Exception\MasterRoleException;
use app\Exception\UserDoesntExistException;
use app\Util\StaticValidator;

class RoleChangeValidator
{
    /**
     * @throws MasterRoleException
     * @throws UserDoesntExistException
     */
    public function validate(?object $user)
    {
        StaticValidator::assertUserDoesntExist($user);
        StaticValidator::assertMasterRoleChange($user);
    }

}