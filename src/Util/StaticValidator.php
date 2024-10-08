<?php

namespace app\Util;

use AllowDynamicProperties;
use app\Exception\PasswordDoesntMatchException;
use app\Exception\UserDoesntExistException;
use app\MysqlClient;
use app\Exception\EmailAlreadyExistsException;
use app\Exception\UsernameAlreadyExistsException;


#[AllowDynamicProperties] class StaticValidator
{


    public static function assertEmailExists(string $email, MysqlClient $db)
    {
        $builder = $db->createQueryBuilder();
        $builder->select('email');
        $builder->from('user');
        $builder->where('email', '=', $email);
        if (is_array($db->getOneOrNullResult($builder->getSelectQuery()))) {
            throw new EmailAlreadyExistsException();
        }
    }
    public static function assertUsernameExists(string $username, MysqlClient $db)
    {
        $builder = $db->createQueryBuilder();
        $builder->select('user_name');
        $builder->from('user');
        $builder->where('user_name', '=', $username);
        if (is_array($db->getOneOrNullResult($builder->getSelectQuery()))) {
            throw new UsernameAlreadyExistsException();
        }
    }

    public static function verifyLoginRequest(string $username, string $password, MysqlClient $db)
    {
        $builder = $db->createQueryBuilder();
        $builder->select();
        $builder->from('user');
        $builder->where('user_name', '=', $username);
        $userData = $db->getOneOrNullResult($builder->getSelectQuery());
        if (is_null($userData)){
            throw new UserDoesntExistException();
        } elseif (!password_verify($password, $userData['password_hash'])){
            throw new PasswordDoesntMatchException();
        }
    }
    public static function assertConfirmPassword(string $password, string $passwordHash)
    {
        if (!password_verify($password, $passwordHash)){
            throw new PasswordDoesntMatchException();
        }
    }
}