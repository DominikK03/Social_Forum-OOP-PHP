<?php

namespace app\Repository;

use AllowDynamicProperties;
use app\MysqlClient;
use app\Model\User;

#[AllowDynamicProperties]
class RegistrationRepository
{
    public function __construct(MysqlClient $client)
    {
        $this->client = $client;
    }


    public function registerUser(User $user)
    {
        $insertBuilder = $this->client->createQueryBuilder();
        $insertBuilder->insert('user', [
            'user_id' => $user->getUserId(),
            'user_name' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password_hash' => $user->getPasswordHash(),
            'role' => $user->getRole()->name,
            'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        $this->client->pushWithoutResults($insertBuilder->getInsertQuery());

    }

}