<?php

namespace app\Factory;

use app\Model\Comment;
use app\Model\User;
use DateTime;
use Ramsey\Uuid\Uuid;

class CommentFactory
{
    public function createComment(string $content, User $user): Comment
    {
        return new Comment(Uuid::uuid4(), $content, new DateTime(), $user);
    }

}