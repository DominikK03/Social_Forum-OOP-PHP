<?php

namespace app\Exception;

use Exception;

class KeyAlreadyExistException extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }
}