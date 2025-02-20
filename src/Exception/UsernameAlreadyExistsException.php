<?php

namespace app\Exception;

class UsernameAlreadyExistsException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Username already exists');
    }
}