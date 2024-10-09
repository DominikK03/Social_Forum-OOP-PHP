<?php

namespace app\Repository;

use app\Model\Image;
use DateTime;

class ImageRepository
{
    public function uploadImage(Image $image)
    {
        move_uploaded_file(
            $image->getImageTmpName(),
            STORAGE_IMAGES_PATH . '/' . $image->getImageName() . "." . str_replace('image/','', $image->getImageType())
        );

    }
}