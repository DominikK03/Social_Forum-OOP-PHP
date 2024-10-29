<?php

namespace app\Repository\Admin;

use AllowDynamicProperties;
use app\Enum\Role;
use app\Model\User;
use app\MysqlClientInterface;

#[AllowDynamicProperties] class AdminRepository implements AdminRepositoryInterface
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

    public function deletePost(string $getDeletePostID)
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->delete('post')
            ->where('post_id', '=', $getDeletePostID);
        $this->client->pushWithoutResults($builder->getDeleteQuery());
    }
    public function deleteCommentByID(string $commentID)
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->delete('comment')
            ->where('comment_id', '=', $commentID);
        $this->client->pushWithoutResults($builder->getDeleteQuery());
    }
}