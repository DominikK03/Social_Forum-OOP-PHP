<?php

namespace app\Exception;

class WrongPasswordException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid password');
    }
}