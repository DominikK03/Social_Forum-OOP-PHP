<?php

namespace app\Service\Post;


use AllowDynamicProperties;
use app\Factory\PostFactory;
use app\Model\Image;
use app\Repository\Auth\AuthRepositoryInterface;
use app\Repository\Post\PostRepositoryInterface;

#[AllowDynamicProperties] class PostService
{
    public function __construct(
        PostFactory             $postFactory,
        AuthRepositoryInterface $authRepository,
        PostRepositoryInterface $postRepository
    )
    {
        $this->authRepository = $authRepository;
        $this->postFactory = $postFactory;
        $this->postRepository = $postRepository;
    }

    public function createPost(
        string  $postTitle,
        ?string $postContent,
        ?string $postLink,
        Image   $image = null)
    {
        $user = $this->authRepository->findByUsername($_SESSION['user']['username']);
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

}