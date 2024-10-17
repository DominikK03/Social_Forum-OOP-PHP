<?php

namespace app\Repository;

use app\Model\Image;

interface ImageRepositoryInterface
{
    public function uploadImage(Image $image);
    public function uploadAvatar(Image $image);
    public function deleteAvatar(string $avatarName);

}