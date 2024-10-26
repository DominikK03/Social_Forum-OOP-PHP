<?php

namespace app\Exception;

class MasterRoleException extends \Exception
{
    protected $message = "You cannot change master role!";
}