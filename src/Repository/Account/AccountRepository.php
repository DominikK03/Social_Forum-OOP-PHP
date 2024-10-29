<?php

namespace app\Repository\Account;

use AllowDynamicProperties;
use app\Model\Image;
use app\Model\User;
use app\MysqlClientInterface;
use app\Repository\Image\ImageRepository;

#[AllowDynamicProperties] class AccountRepository implements AccountRepositoryInterface
{
    public function __construct(
        MysqlClientInterface $client,
        ImageRepository      $imageRepository
    )
    {
        $this->client = $client;
        $this->imageRepository = $imageRepository;
    }

    public function updatePassword(User $user, string $newPassword): void
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

    public function insertAvatarImage(Image $image, string $username): void
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->update('user', ['avatar' => $image->getImageName()])
            ->where('user_name', '=', $username);
        $_SESSION['user']['avatar'] = $this->client->getOneOrNullResult($builder->getUpdateQuery());
    }

    public function deleteAccount(User $user)
    {

        $accountDeleteBuilder =
            $this->client->createQueryBuilder()
                ->delete('user')
                ->where('user_id', '=', $user->getUserId());
        $this->client->pushWithoutResults($accountDeleteBuilder->getDeleteQuery());

    }
    public function deleteImagesAssignedToAccount(User $user)
    {
        $avatarDeleted = false;
        $imageDeleteBuilder =
            $this->client->createQueryBuilder()
                ->select("post.image, user.avatar")
                ->from('post')
                ->join('user', 'post.user_id = user.user_id')
                ->where('post.user_id', '=', $user->getUserId());
        $images = $this->client->getResults($imageDeleteBuilder->getSelectQuery());
        foreach ($images as $image) {
            if (!empty($image['image'])){
                $this->imageRepository->deleteImage($image['image']);
            }
            if (!$avatarDeleted) {
                $this->imageRepository->deleteAvatar($image['avatar']);
                $avatarDeleted = true;
            }
        }

    }

}