<?php

namespace app\Repository;

use AllowDynamicProperties;
use app\Model\User;
use app\MysqlClient;

#[AllowDynamicProperties] class AccountRepository
{
    public function __construct(MysqlClient $client)
    {
        $this->client = $client;
    }

    public function updatePassword(User $user, string $newPassword)
    {
        $builder = $this->client->createQueryBuilder();
        $builder->update('user',['password_hash'=>password_hash($newPassword,PASSWORD_BCRYPT)]);
        $builder->where('user_id','=', $user->getUserId());
        $this->client->pushWithoutResults($builder->getUpdateQuery());
    }

}