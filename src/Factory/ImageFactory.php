<?php

namespace app\Factory;

use app\Model\Image;
use DateTime;

class ImageFactory
{

    public function createImage(string $imageTmpName, string $imageType, int $imageSize, $imageName = new DateTime()): Image
    {
        $imageName = $imageName->format('YmdHi') . "." . str_replace("image/",'',$imageType);
        return new Image($imageName, $imageTmpName, $imageType, $imageSize);
    }
}