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

    public function verifyUser(string $username, string $password): array
    {
        StaticValidator::verifyLoginRequest($username, $password, $this->client);
        $builder = $this->client->createQueryBuilder();
        $builder->select();
        $builder->from('user');
        $builder->where('user_name', '=', $username);
        return $this->client->getOneOrNullResult($builder->getSelectQuery());
    }

}