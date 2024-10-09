<?php

namespace app\Exception;

class FileIsntImageException extends \Exception
{
    protected $message = 'File is not an image';
}