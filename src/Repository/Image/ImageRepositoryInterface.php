<?php

namespace app\Repository\Image;

use app\Model\Image;

interface ImageRepositoryInterface
{
    public function uploadImage(Image $image);
    public function uploadAvatar(Image $image);
    public function deleteAvatar(string $avatarName);

}