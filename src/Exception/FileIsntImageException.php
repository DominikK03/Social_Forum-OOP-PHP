<?php

namespace app\Exception;

class FileIsntImageException extends \Exception
{
   public function __construct()
   {
       parent::__construct('File is not an image');
   }
}