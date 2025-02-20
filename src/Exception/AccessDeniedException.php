<?php

namespace app\Exception;
class AccessDeniedException extends \Exception
{
    public function __construct()
    {
        parent::__construct('', 403);
    }
}