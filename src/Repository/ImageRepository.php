<?php

namespace app\Repository;

use app\Model\Image;

class ImageRepository
{
    public function uploadImage(Image $image)
    {
        move_uploaded_file(
            $image->getImageTmpName(),
            STORAGE_IMAGES_PATH . '/' . $image->getImageName()
        );
    }

    public function uploadAvatar(Image $image)
    {
        move_uploaded_file(
            $image->getImageTmpName(),
            STORAGE_IMAGES_PATH . '/avatars/' . $image->getImageName()
        );
    }

    public function deleteAvatar(string $avatarName)
    {
        if (file_exists(STORAGE_IMAGES_PATH . '/avatars/' . $avatarName)) {
            unlink(STORAGE_IMAGES_PATH . '/avatars/' . $avatarName);
        }
    }
}