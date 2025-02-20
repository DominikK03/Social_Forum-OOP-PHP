<?php

namespace app\Core\DI\Exception;

class ClassNotFoundException extends \Exception
{
    protected $message = 'Class not found in Container';


}