<?php

namespace app\Service;

use AllowDynamicProperties;
use app\Factory\CommentFactory;
use app\Model\Comment;
use app\Repository\AuthRepositoryInterface;
use app\Service\Validator\CommentValidator;


#[AllowDynamicProperties] class CommentService
{
    public function __construct(
        CommentFactory          $commentFactory,
        AuthRepositoryInterface $authRepository,
        CommentValidator        $commentValidator)
    {
        $this->authRepository = $authRepository;
        $this->commentFactory = $commentFactory;
        $this->commentValidator = $commentValidator;
    }

    public function setCommentData(
        string $commentContent,
        string $username,
        string $postID
    ): Comment
    {
        $this->commentValidator->validate($commentContent);
        $user = $this->authRepository->findByUsername($username);
        var_dump($user);
        return $this->commentFactory->createComment($commentContent, $user, $postID);
    }
}