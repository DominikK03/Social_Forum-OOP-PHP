<?php

namespace app\Exception;
class KeyDoesntExistException extends \Exception
{
    public function __construct()
    {
        parent::__construct();
    }
}