<?php

namespace app\Repository\Admin;

use AllowDynamicProperties;
use app\PDO\MysqlClientInterface;
use app\Enum\Role;
use app\Model\User;
use const app\Model\USER;

#[AllowDynamicProperties]
class AdminRepository implements AdminRepositoryInterface
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
            ->where('userName', '=', $user->getUsername()
            );
        $this->client->persist($builder->getUpdateQuery());
    }
    public function deletePost(string $getDeletePostID)
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->delete('post')
            ->where('postID', '=', $getDeletePostID);
        $this->client->persist($builder->getDeleteQuery());
    }
    public function deleteCommentByID(string $commentID)
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->delete('comment')
            ->where('commentID', '=', $commentID);
        $this->client->persist($builder->getDeleteQuery());
    }
}