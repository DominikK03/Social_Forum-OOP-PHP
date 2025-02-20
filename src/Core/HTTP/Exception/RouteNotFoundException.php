<?php

namespace app\Core\HTTP\Exception;
class RouteNotFoundException extends \Exception
{
    protected $message = '404 Not Found';
}