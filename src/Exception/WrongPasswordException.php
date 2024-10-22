<?php

namespace app\Exception;

class WrongPasswordException extends \Exception
{
    protected $message = 'Invalid password';
}