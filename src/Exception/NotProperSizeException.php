<?php

namespace app\Exception;

use Exception;

class NotProperSizeException extends Exception
{
    public function __construct()
    {
        parent::__construct('Image has not proper size');
    }
}