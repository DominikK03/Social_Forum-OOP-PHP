<?php

namespace app\Repository\Post;

use AllowDynamicProperties;
use app\PDO\MysqlClientInterface;
use app\Model\Post;

#[AllowDynamicProperties]
class PostRepository implements PostRepositoryInterface
{
    public function __construct(MysqlClientInterface $client)
    {
        $this->client = $client;
    }
    public function insertPost(Post $post)
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->insert('post', [
                'postID' => $post->getPostId(),
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'image' => $post->getImage()?->imageName,
                'link' => $post->getLink(),
                'createdAt' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
                'userID' => $post->getUser()->getUserId()
            ]);
        $this->client->persist($builder->getInsertQuery());
    }
    public function getPosts(): array
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select([
                "post.postID",
                "post.title",
                "post.content",
                "post.image",
                "post.link",
                "post.createdAt",
                "user.userName",
                "user.avatar"
            ])
            ->from('post')
            ->join('user', 'post.userID = user.userID')
            ->orderBy("post.createdAt", "DESC");
        return $this->client->persist($builder->getSelectQuery())->getResults();
    }
    public function getPost(string $postID): array
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select([
                "post.postID",
                "post.title",
                "post.content",
                "post.image",
                "post.link",
                "post.createdAt",
                "user.userName",
                "user.avatar"
            ])
            ->from('post')
            ->join('user', 'post.userID = user.userID')
            ->where('post.postID', '=', $postID);
        return $this->client->persist($builder->getSelectQuery())->getOneOrNullResult();
    }
    public function countComments(string $postID): int
    {
        $builder = $this->client->createQueryBuilder()
            ->select(['commentID'])
            ->from('comment')
            ->where('postID', '=', $postID);
        return count($this->client->persist($builder->getSelectQuery())->getResults());
    }
}