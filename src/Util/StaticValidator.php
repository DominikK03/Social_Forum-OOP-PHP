<?php

namespace app\Util;

use AllowDynamicProperties;
use app\Exception\FileIsntImageException;
use app\Exception\NotProperSizeException;
use app\Exception\PasswordDoesntMatchException;
use app\Exception\UserDoesntExistException;
use app\MysqlClient;
use app\Exception\EmailAlreadyExistsException;
use app\Exception\UsernameAlreadyExistsException;


#[AllowDynamicProperties] class StaticValidator
{


    /**
     * @throws EmailAlreadyExistsException
     */
    public static function assertEmailExists(string $email, ?array $users)
    {
        if (!is_null($users) && in_array($email, $users)) {
            throw new EmailAlreadyExistsException();
        }
    }

    /**
     * @throws UsernameAlreadyExistsException
     */
    public static function assertUsernameExists(string $username, ?array $users)
    {
        if (!is_null($users) && in_array($username, $users)) {
            throw new UsernameAlreadyExistsException();
        }
    }

    /**
     * @throws PasswordDoesntMatchException
     * @throws UserDoesntExistException
     */
    public static function verifyLoginRequest(?object $user, string $username, string $password, ?string $passwordHash)
    {
        if ($user == null || $username !== $user->getUsername()){
            throw new UserDoesntExistException();
        } elseif (!password_verify($password, $passwordHash)){
            throw new PasswordDoesntMatchException();
        }
    }

    /**
     * @throws PasswordDoesntMatchException
     */
    public static function assertConfirmPassword(string $password, string $passwordHash)
    {
        if (!password_verify($password, $passwordHash)){
            throw new PasswordDoesntMatchException();
        }
    }

    /**
     * @throws FileIsntImageException
     */
    public static function assertIsImage(string $fileType)
    {
        $allowedTypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
        if (!in_array($fileType,$allowedTypes)){
            throw new FileIsntImageException();
        }
    }
    /**
     * @throws NotProperSizeException
     */
    public static function assertIsProperSize(int $fileSize)
    {
        if(!($fileSize < 1000000)){
            throw new NotProperSizeException();
        }
    }
}