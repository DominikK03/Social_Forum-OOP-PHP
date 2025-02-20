<?php

namespace app\Exception;
class FileNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("File not found", 404);
    }
}