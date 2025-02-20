<?php

namespace app\Core\DI\Exception;

use Throwable;

class ClassNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Class not found in Container');
    }
}