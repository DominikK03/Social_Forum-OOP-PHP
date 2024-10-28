<?php

namespace app\Repository\Comment;

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
        $this->client->pushWithoutResults($builder->getInsertQuery());
    }

    public function getComments(string $postID) : array
    {
        $builder = $this->client->createQueryBuilder()
            ->select("
            comment.comment_id,
            comment.content,
            comment.created_at,
            comment.post_id,
            user.avatar,
            user.user_name")
            ->from('comment')
            ->join('user', 'comment.user_id = user.user_id')
            ->where('comment.post_id', '=', $postID)
            ->orderBy('comment.created_at', 'DESC');
        return $this->client->getResults($builder->getSelectQuery());
    }
}