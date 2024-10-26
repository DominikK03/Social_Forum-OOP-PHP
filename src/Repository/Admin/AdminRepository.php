<?php

namespace app\Repository\Admin;

use AllowDynamicProperties;
use app\Enum\Role;
use app\Model\User;
use app\MysqlClientInterface;

#[AllowDynamicProperties] class AdminRepository
{
    public function __construct(MysqlClientInterface $client)
    {
        $this->client = $client;
    }

    public function updateUserRole(User $user, Role $role)
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->update('user', ['role' => $role->name])
            ->where('user_name', '=', $user->getUsername()
            );
        $this->client->pushWithoutResults($builder->getUpdateQuery());
    }
}