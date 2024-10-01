<?php

namespace app\Exception;

use Exception;

class PasswordDoesntMatchException extends Exception
{
    protected $message = 'Wrong Password given';

}