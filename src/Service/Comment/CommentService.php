<?php

namespace app\Service\Comment;

use AllowDynamicProperties;
use app\Factory\CommentFactory;
use app\Repository\Auth\AuthRepositoryInterface;
use app\Repository\Comment\CommentRepositoryInterface;
use app\Service\Validator\CommentValidator;

#[AllowDynamicProperties]
class CommentService
{
    public function __construct(
        CommentFactory $commentFactory,
        AuthRepositoryInterface $authRepository,
        CommentValidator $commentValidator,
        CommentRepositoryInterface $commentRepository
    )
    {
        $this->authRepository = $authRepository;
        $this->commentFactory = $commentFactory;
        $this->commentValidator = $commentValidator;
        $this->commentRepository = $commentRepository;
    }
    public function createComment(
        string $commentContent,
        string $username,
        string $postID
    )
    {
        $this->commentValidator->validate($commentContent);
        $user = $this->authRepository->findByUsername($username);
        $this->commentRepository->insertComment(
            $this->commentFactory->fromUserInput($commentContent, $user, $postID)
        );
    }
}