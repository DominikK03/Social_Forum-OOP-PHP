<?php

namespace app\Exception;

use Exception;

class NotProperSizeException extends Exception
{
    protected $message = 'Image has not proper size';
}