<?php

namespace app\Util;

use AllowDynamicProperties;
use app\mysqlClient;
use app\Exception\EmailAlreadyExistsException;
use app\Exception\UsernameAlreadyExistsException;


#[AllowDynamicProperties] class StaticValidator
{


    public static function assertEmailExists(string $email, mysqlClient $DB)
    {
        $DB->query('SELECT email FROM user WHERE email = ":email"');
        $DB->bind(':email', $email);
        if ($DB->rowCount() > 0)
        {
            throw new EmailAlreadyExistsException();
        }
    }
    public static function assertUsernameExists(string $username, mysqlClient $DB)
    {
        $DB->query('SELECT user_name FROM user WHERE user_name = ":username"');
        $DB->bind(':username', $username);
        if ($DB->rowCount() > 0)
        {
            throw new UsernameAlreadyExistsException();
        }

    }
}