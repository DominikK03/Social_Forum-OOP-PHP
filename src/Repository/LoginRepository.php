<?php

namespace app\Repository;

use AllowDynamicProperties;
use app\Enum\Role;
use app\Model\User;
use app\MysqlClient;
use DateTime;

#[AllowDynamicProperties] class LoginRepository
{
    public function __construct(MysqlClient $client)
    {
        $this->client = $client;
    }

    /**
     * @throws \Exception
     */
    public function handleLogin(string $username) : User
    {
        $builder = $this->client->createQueryBuilder();
        $builder->select();
        $builder->from('user');
        $builder->where('user_name', '=', $username);
        $userData = $this->client->getOneOrNullResult($builder->getSelectQuery());
        return new User(
            $userData['user_id'],
            $userData['user_name'],
            $userData['email'],
            $userData['password_hash'],
            new DateTime($userData['created_at'])
            );
    }
}