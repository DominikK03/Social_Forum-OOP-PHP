<?php

namespace app\Exception;


use Exception;

class EmptyCommentException extends Exception
{
    protected $message = "Comment cannot be empty";
}