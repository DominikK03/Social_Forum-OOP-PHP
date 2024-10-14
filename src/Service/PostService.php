<?php

namespace app\Service;


use AllowDynamicProperties;
use app\Factory\ImageFactory;
use app\Factory\PostFactory;
use app\Model\Image;
use app\Model\Post;
use app\Repository\AuthRepository;
use app\Repository\AuthRepositoryInterface;
use app\Service\Validator\ImageValidator;

#[AllowDynamicProperties] class PostService
{
    public function __construct(
        PostFactory    $postFactory,
        AuthRepositoryInterface $authRepository,
        ImageFactory   $imageFactory,
        ImageValidator $imageValidator)
    {
        $this->authRepository = $authRepository;
        $this->postFactory = $postFactory;
        $this->imageFactory = $imageFactory;
        $this->imageValidator = $imageValidator;
    }

    public function setImageData(
        string $imageName,
        string $imageTmpName,
        string $imageType,
        int    $imageSize): Image
    {
        $this->imageValidator->validateImage($imageType, $imageSize);
        return $this->imageFactory->createImage($imageName, $imageTmpName, $imageType, $imageSize);
    }

    public function setPostData(
        string  $postTitle,
        ?string $postContent,
        ?string $postLink,
        Image   $image = null): Post
    {
        $user = $this->authRepository->findByUsername($_SESSION['user']['username']);
        return $this->postFactory->createPost($postTitle, $user, $image, $postContent, $postLink);
    }

}