<?php

namespace app\Core\DI\Exception;
class ContainerCannotBuildGenericException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Cannot Build');
    }
}