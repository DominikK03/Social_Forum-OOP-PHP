<?php

namespace app\Service;

use AllowDynamicProperties;
use app\Factory\ImageFactory;
use app\Model\Image;
use DateTime;


#[AllowDynamicProperties] class ImageService
{
    public function __construct(ImageFactory $imageFactory, ImageValidator $imageValidator)
    {
        $this->imageFactory = $imageFactory;
        $this->validate = $imageValidator;
    }

    public function setImageData(string $imageTmpName, string $imageType, int $imageSize): Image
    {
        $this->validate->validateImage($imageType, $imageSize);
        return $this->imageFactory->createImage($imageTmpName, $imageType, $imageSize);
    }


}