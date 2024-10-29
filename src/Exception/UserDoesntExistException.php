<?php

namespace app\Exception;

use Exception;

class UserDoesntExistException extends Exception
{
    protected $message = "User doesn't exist";

}