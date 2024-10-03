<?php

namespace app\Service;

use AllowDynamicProperties;
use app\MysqlClient;
use app\Util\StaticValidator;

#[AllowDynamicProperties] class LoginService
{
    public function __construct(MysqlClient $client)
    {
        $this->client = $client;
    }

    public function verifyUser(string $username, string $password): string
    {
        StaticValidator::verifyLoginRequest($username, $password, $this->client);
        return $username;
    }

}