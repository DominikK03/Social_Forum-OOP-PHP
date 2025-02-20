<?php

namespace app\Repository\Image;

use app\Model\Image;

interface FileSystemImageRepositoryInterface
{
    public function uploadImage(Image $image);
    public function uploadAvatar(Image $image);
    public function deleteAvatar(string $avatarName);
    public function deleteImage(string $imageName);
}