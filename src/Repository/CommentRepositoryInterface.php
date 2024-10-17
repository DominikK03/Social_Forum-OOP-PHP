<?php

namespace app\Repository;

use app\Model\Comment;

interface CommentRepositoryInterface
{
    public function insertComment(Comment $comment);
}