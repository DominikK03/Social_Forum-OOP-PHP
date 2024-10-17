<?php

namespace app\Repository;

use AllowDynamicProperties;
use app\Model\Image;
use app\Model\User;
use app\MysqlClient;
use app\MysqlClientInterface;

#[AllowDynamicProperties] class AccountRepository implements AccountRepositoryInterface
{
    public function __construct(MysqlClientInterface $client)
    {
        $this->client = $client;
    }

    public function updatePassword(User $user, string $newPassword)
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->update('user', ['password_hash' => password_hash($newPassword, PASSWORD_BCRYPT)])
            ->where('user_id', '=', $user->getUserId());
        $this->client->pushWithoutResults($builder->getUpdateQuery());
    }

    public function getUserAvatar(string $username): string
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select('avatar')
            ->from('user')->where('user_name', '=', $username);
        return $this->client->getOneOrNullResult($builder->getSelectQuery())['avatar'];
    }

    public function setAvatar(Image $image, string $username)
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->update('user', ['avatar' => $image->getImageName()])
            ->where('user_name', '=', $username);
        $this->client->pushWithoutResults($builder->getUpdateQuery());
    }

}