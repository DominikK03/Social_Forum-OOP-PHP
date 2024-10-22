<?php

namespace app\Service\Image;

use AllowDynamicProperties;
use app\Factory\ImageFactory;
use app\Model\Image;
use app\Repository\Image\ImageRepositoryInterface;
use app\Service\Validator\ImageValidator;


#[AllowDynamicProperties] class ImageService
{
    public function __construct(
        ImageFactory             $imageFactory,
        ImageValidator           $imageValidator,
        ImageRepositoryInterface $imageRepository)
    {
        $this->imageFactory = $imageFactory;
        $this->imageValidator = $imageValidator;
        $this->imageRepository = $imageRepository;
    }

    public function createImage(
        string $imageName,
        string $imageTmpName,
        string $imageType,
        int    $imageSize
    ) : Image
    {
        $this->imageValidator->validateImage($imageType, $imageSize);
        return $this->imageFactory->fromUserInput(
            $imageName, $imageTmpName, $imageType, $imageSize
        );
    }
    public function uploadPostImage(Image $image)
    {
        $this->imageRepository->uploadImage($image);
    }

    public function updateAvatar(Image $image, string $avatarName)
    {
        $this->imageRepository->deleteAvatar($avatarName);
        $this->imageRepository->uploadAvatar($image);
    }


}