<?php

namespace app\Repository\Comment;

use app\Model\Comment;

interface CommentRepositoryInterface
{
    public function insertComment(Comment $comment);
    public function getComments(string $postID) : array;

    public function deleteCommentByID(string $commentID);
}