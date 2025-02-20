<?php

namespace app\Repository\Account;

use app\Model\Image;
use app\Model\User;

interface MysqlAccountRepositoryInterface
{
    public function updatePassword(User $user, string $newPassword);
    public function getUserAvatar(string $username): string;
    public function insertAvatarImage(Image $image, string $username);
    public function deleteAccount(User $user);
    public function deleteImagesAssignedToAccount(User $user);
}