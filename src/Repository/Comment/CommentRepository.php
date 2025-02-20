<?php

namespace app\Repository\Comment;

use AllowDynamicProperties;
use app\PDO\MysqlClientInterface;
use app\Model\Comment;

#[AllowDynamicProperties]
class CommentRepository implements CommentRepositoryInterface
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
                'commentID' => $comment->commentId->toString(),
                'content' => $comment->content,
                'createdAt' => $comment->createdAt->format('Y-m-d H:i:s'),
                'userID' => $comment->user->getUserId(),
                'postID' => $comment->currentPostID
            ]);
        $this->client->persist($builder->getInsertQuery());
    }
    public function getComments(string $postID): array
    {
        $builder = $this->client->createQueryBuilder()
            ->select([
            "comment.commentID",
            "comment.content",
            "comment.createdAt",
            "comment.postID",
            "user.avatar",
            "user.userName"
            ])
            ->from('comment')
            ->join('user', 'comment.userID = user.userID')
            ->where('comment.postID', '=', $postID)
            ->orderBy('comment.createdAt', 'DESC');
        return $this->client->persist($builder->getSelectQuery())->getResults();
    }
}