<?php

namespace app\Repository\Image;

use app\Model\Image;

class ImageRepository implements ImageRepositoryInterface
{
    public function uploadImage(Image $image)
    {
        move_uploaded_file(
            $image->getImageTmpName(),
            STORAGE_IMAGES_PATH . '/' . $image->getImageName()
        );
    }
    public function deleteImage(string $imageName)
    {
        if (file_exists(STORAGE_IMAGES_PATH . '/' . $imageName)) {
            unlink(STORAGE_IMAGES_PATH . '/' . $imageName);
        }
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
        if (file_exists(STORAGE_IMAGES_PATH . '/avatars/' . $avatarName) && $avatarName !== 'defaultImage.png') {
            unlink(STORAGE_IMAGES_PATH . '/avatars/' . $avatarName);
        }
    }
}