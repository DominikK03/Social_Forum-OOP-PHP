<?php

namespace app\Exception;

use Exception;

class EmailAlreadyExistsException extends Exception
{
    protected $message = 'E-mail already exists';

}