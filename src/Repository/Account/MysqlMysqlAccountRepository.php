<?php

namespace app\Repository\Account;

use AllowDynamicProperties;
use app\Model\Image;
use app\Model\User;
use app\PDO\MysqlClientInterface;
use app\Repository\Image\FileSystemImageRepository;
use app\Util\SessionManager;
use const app\Model\USER;
use const app\Model\USERID;

#[AllowDynamicProperties]
class MysqlMysqlAccountRepository implements MysqlAccountRepositoryInterface
{
    public function __construct(
        MysqlClientInterface $client,
        FileSystemImageRepository $imageRepository,
        SessionManager $sessionManager
    )
    {
        $this->client = $client;
        $this->imageRepository = $imageRepository;
        $this->sessionManager = $sessionManager;
    }
    public function updatePassword(User $user, string $newPassword): void
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->update('user', ['passwordHash' => password_hash($newPassword, PASSWORD_BCRYPT)])
            ->where('userID', '=', $user->getUserId());
        $this->client->persist($builder->getUpdateQuery());
    }
    public function getUserAvatar(string $username): string
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select(['avatar'])
            ->from('user')->where('userName', '=', $username);
        return $this->client->persist($builder->getSelectQuery())->getOneOrNullResult()['avatar'];
    }
    public function insertAvatarImage(Image $image, string $username): void
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->update('user', ['avatar' => $image->imageName])
            ->where('userName', '=', $username);
        $this->sessionManager->alterSession(
            'user',
            'avatar',
            $this->client->persist($builder->getUpdateQuery())->getOneOrNullResult()
        );
    }
    public function deleteAccount(User $user)
    {
        $accountDeleteBuilder =
            $this->client->createQueryBuilder()
                ->delete('user')
                ->where('userID', '=', $user->getUserId());
        $this->client->persist($accountDeleteBuilder->getDeleteQuery());
    }
    public function deleteImagesAssignedToAccount(User $user)
    {
        $avatarDeleted = false;
        $imageDeleteBuilder =
            $this->client->createQueryBuilder()
                ->select(["post.image, user.avatar"])
                ->from('post')
                ->join('user', 'post.userID = user.userID')
                ->where('post.userID', '=', $user->getUserId());
        $images = $this->client->persist($imageDeleteBuilder->getSelectQuery())->getResults();
        foreach ($images as $image) {
            if (!empty($image['image'])) {
                $this->imageRepository->deleteImage($image['image']);
            }
            if (!$avatarDeleted) {
                $this->imageRepository->deleteAvatar($image['avatar']);
                $avatarDeleted = true;
            }
        }
    }
}