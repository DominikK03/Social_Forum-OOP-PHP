<?php

namespace app\Repository;

use AllowDynamicProperties;
use app\Model\Comment;
use app\MysqlClientInterface;

#[AllowDynamicProperties] class CommentRepository implements CommentRepositoryInterface
{
    public function __construct(MysqlClientInterface $client)
    {
        $this->client = $client;
    }

    public function insertComment(Comment $comment)
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->insert('comment', [
                'comment_id', $comment->getCommentId(),
                'content' => $comment->getContent(),
                'created_at' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
                'user_id' => $comment->getUser()->getUserId(),
                'post_id' => $comment->getPostId()
            ]);
        $this->client->pushWithoutResults($builder->getInsertQuery());
    }

}