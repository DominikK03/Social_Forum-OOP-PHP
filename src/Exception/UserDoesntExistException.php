<?php

namespace app\Exception;

use Exception;

class UserDoesntExistException extends Exception
{
    public function __construct()
    {
        parent::__construct("User doesn't exist");
    }
}