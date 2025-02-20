<?php

namespace app\Repository\Image;

use app\Model\Image;
use app\Util\FileSystem;

class FileSystemImageRepository implements FileSystemImageRepositoryInterface
{
    public function uploadImage(Image $image)
    {
        FileSystem::moveFile(
            $image->imageTmpName,
            STORAGE_IMAGES_PATH . '/' . $image->imageName
        );
    }
    public function deleteImage(string $imageName)
    {
        FileSystem::deleteFile(STORAGE_IMAGES_PATH . '/' . $imageName);
    }
    public function uploadAvatar(Image $image)
    {
        FileSystem::moveFile(
            $image->imageTmpName,
            STORAGE_AVATARS_PATH . $image->imageName
        );
    }
    public function deleteAvatar(string $avatarName)
    {
        FileSystem::deleteFile(STORAGE_AVATARS_PATH . $avatarName);
    }
}
