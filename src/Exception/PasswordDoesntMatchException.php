<?php

namespace app\Exception;

use Exception;

class PasswordDoesntMatchException extends Exception
{
    public function __construct()
    {
        parent::__construct('Wrong Password given');
    }
}