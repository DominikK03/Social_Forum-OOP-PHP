<?php

namespace app\Repository;

use AllowDynamicProperties;
use app\Model\User;
use app\MysqlClient;
use DateTime;
use Ramsey\Uuid\Uuid;

#[AllowDynamicProperties] class AuthRepository
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
    /**
     * @throws \Exception
     */
    public function findByUsername(string $username) : ?User
    {
        $builder = $this->client->createQueryBuilder();
        $builder->select();
        $builder->from('user');
        $builder->where('user_name', '=', $username);
        $userData = $this->client->getOneOrNullResult($builder->getSelectQuery());
        if ($userData) {
            return new User(
                Uuid::fromString($userData['user_id']),
                $userData['user_name'],
                $userData['email'],
                $userData['password_hash'],
                new DateTime($userData['created_at'])
            );
        }
        return null;
    }

}