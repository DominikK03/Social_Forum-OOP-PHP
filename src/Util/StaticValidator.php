<?php

namespace app\Util;

use app\Core\HTTP\Response\JsonResponse;
use app\Exception\InvalidEmailException;
use app\Exception\PasswordDoesntMatchException;

class StaticValidator
{
    /**
     * @throws PasswordDoesntMatchException
     */
    public static function assertCheckPassword(string $password, string $confirmPassword)
    {
        if ($password !== $confirmPassword){
            throw new PasswordDoesntMatchException();
        }
    }
}