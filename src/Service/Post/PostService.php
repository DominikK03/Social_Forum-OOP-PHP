<?php

namespace app\Service\Post;


use AllowDynamicProperties;
use app\Factory\PostFactory;
use app\Model\Image;
use app\Model\User;
use app\Repository\Auth\AuthRepositoryInterface;
use app\Repository\Post\PostRepositoryInterface;
use app\Service\Image\ImageService;

#[AllowDynamicProperties] class PostService
{
    public function __construct(
        PostFactory             $postFactory,
        AuthRepositoryInterface $authRepository,
        PostRepositoryInterface $postRepository,
        ImageService $imageService
    )
    {
        $this->authRepository = $authRepository;
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
        $this->imageService = $imageService;
    }

    public function createPost(
        User $user,
        string  $postTitle,
        ?string $postContent,
        ?string $postLink,
        Image   $image = null)
    {
        $this->postFactory->fromUserInput($postTitle, $user, $image, $postContent, $postLink);
        $this->postRepository->insertPost(
            $this->postFactory->fromUserInput($postTitle, $user, $image, $postContent, $postLink)
        );
    }

    public function getPostsWithCommentRow(): array
    {
        $posts = $this->postRepository->getPosts();
        foreach ($posts as &$post) {
            $post['comment_count'] = $this->postRepository->countComments($post['post_id']);
        }
        return $posts;
    }

    public function deletePostByID(string $deletePostID)
    {
        $post = $this->postRepository->getPost($deletePostID);
        if ($post['image'] != ''){
            $this->imageService->imageRepository->deleteImage($post['image']);
        }
        $this->postRepository->deletePost($post['post_id']);

    }

}