<?php

namespace app\Exception;

class MasterRoleException extends \Exception
{
    public function __construct()
    {
        parent::__construct("You cannot change master role!");
    }
}