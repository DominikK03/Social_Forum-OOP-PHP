<?php

namespace app\Exception;

class UsernameAlreadyExistsException extends \Exception
{
    protected $message = 'Username already exists';

}