<?php

namespace app\Exception;

use Exception;

class EmailAlreadyExistsException extends Exception
{
    public function __construct()
    {
        parent::__construct('E-mail already exists');
    }

}