<?php

namespace app\Util;

use AllowDynamicProperties;
use app\Exception\EmptyCommentException;
use app\Exception\KeyAlreadyExistException;
use app\Exception\KeyDoesntExistException;
use app\Exception\MasterRoleException;
use app\Exception\NotProperSizeException;
use app\Exception\UserDoesntExistException;
use app\Exception\ValuesArentEqualException;

#[AllowDynamicProperties]
class StaticValidator
{
    /**
     * @throws KeyAlreadyExistException
     */
    public static function assertKeyDoesNotExist($key, ?array $array)
    {
        if (!is_null($array) && in_array($key, $array)) {
            throw new KeyAlreadyExistException();
        }
    }
    public static function assertKeyExist($key, ?array $array)
    {
        if(is_null($array) || !in_array($key, $array)){
            throw new KeyDoesntExistException();
        }

    }

    /**
     * @throws NotProperSizeException
     */
    public static function assertGreaterThan($value, $limit)
    {
        if ($value <= $limit) {
            throw new NotProperSizeException();
        }
    }

    /**
     * @throws EmptyCommentException
     */
    public static function assertNotEmpty(string $value)
    {
        if (empty($value)) {
            throw new EmptyCommentException();
        }
    }
    /**
     * @throws ValuesArentEqualException
     */
    public static function assertEquals($value1, $value2)
    {
        if ($value1 !== $value2) {
            throw new ValuesArentEqualException();
        }
    }

    public static function assertInArray($value, array $allowedValues, string $exceptionClass)
    {
        if (!in_array($value, $allowedValues)) {
            throw new $exceptionClass();
        }
    }

    /**
     * @throws NotProperSizeException
     */
    public static function assertLessThanOrEqual($value, $limit)
    {
        if ($value > $limit) {
            throw new NotProperSizeException();
        }
    }
    public static function assertNotNull(?object $value)
    {
        if(is_null($value)){
            throw new UserDoesntExistException();
        }
    }
    public static function assertNotEqual($firstValue, $secondValue)
    {
        if ($firstValue === $secondValue)
        {
            throw new MasterRoleException();
        }
    }
}
