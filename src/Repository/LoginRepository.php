<?php

namespace app\Repository;

use AllowDynamicProperties;
use app\Model\User;
use app\MysqlClient;

#[AllowDynamicProperties] class LoginRepository
{
    public function __construct(MysqlClient $client)
    {
        $this->client = $client;
    }

    public function handleLogin(array $userData) : User
    {
        return new User(
            $userData['user_id'],
            $userData['user_name'],
            $userData['email'],
            $userData['password_hash'],
            $userData['role']);
    }
}