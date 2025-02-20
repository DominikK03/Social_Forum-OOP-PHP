<?php

namespace app\Service\Image;

use AllowDynamicProperties;
use app\Factory\ImageFactory;
use app\Model\Image;
use app\Repository\Image\FileSystemImageRepositoryInterface;
use app\Service\Validator\ImageValidator;

#[AllowDynamicProperties]
class ImageService
{
    public function __construct(
        ImageFactory $imageFactory,
        ImageValidator $imageValidator,
        FileSystemImageRepositoryInterface $imageRepository
    )
    {
        $this->imageFactory = $imageFactory;
        $this->imageValidator = $imageValidator;
        $this->imageRepository = $imageRepository;
    }
    public function createImage(
        string $imageName,
        string $imageTmpName,
        string $imageType,
        int $imageSize
    ): Image
    {
        $this->imageValidator->validateImage($imageType, $imageSize);
        return $this->imageFactory->fromUserInput(
            $imageName, $imageTmpName, $imageType, $imageSize
        );
    }
    public function createAvatarImage(
        string $userName,
        string $avatarTmpName,
        string $avatarType,
        int $avatarSize
    ): Image
    {
        $avatarExtension = str_replace('image/', '', $avatarType);
        $avatarName = "avatar-" . $userName . "." . $avatarExtension;
        $this->imageValidator->validateImage($avatarType, $avatarSize);
        return $this->imageFactory->fromUserInput(
            $avatarName, $avatarTmpName, $avatarType, $avatarSize
        );
    }
    public function createPostImage(
        string $imageTmpName,
        string $imageType,
        int $imageSize
    ): Image
    {
        $imageName = (new \DateTime())->format('Ymdhis') . "."
            . str_replace('image/', '', $imageType);
        return $this->imageFactory->fromUserInput(
            $imageName, $imageTmpName, $imageType, $imageSize
        );
    }
    public function uploadPostImage(Image $image): void
    {
        $this->imageRepository->uploadImage($image);
    }
    public function updateAvatar(Image $image): void
    {
        $this->imageRepository->deleteAvatar($image->imageName);
        $this->imageRepository->uploadAvatar($image);
    }
}