<?php

namespace app\Repository;

use app\Model\Image;
use app\Model\User;

interface AccountRepositoryInterface
{
    public function updatePassword(User $user, string $newPassword);
    public function getUserAvatar(string $username): string;
    public function setAvatar(Image $image, string $username);


}