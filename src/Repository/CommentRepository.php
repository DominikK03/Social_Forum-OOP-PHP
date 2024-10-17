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
                'comment_id' => $comment->getCommentId()->toString(),
                'content' => $comment->getContent(),
                'created_at' => $comment->getCreatedAt()->format('Y-m-d H:i:s'),
                'user_id' => $comment->getUser()->getUserId(),
                'post_id' => $comment->getCurrentPostId()
            ]);
        var_dump($builder->getInsertQuery());
        $this->client->pushWithoutResults($builder->getInsertQuery());
    }

    public function getPosts(): array
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select(
                )
            ->from('post')
            ->join('user', 'post.user_id = user.user_id')
            ->orderBy("post.created_at", "DESC");
        return $this->client->getResults($builder->getSelectQuery());
    }

}