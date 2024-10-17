<?php

namespace app\Repository;

use AllowDynamicProperties;
use app\Model\Post;
use app\MysqlClientInterface;

#[AllowDynamicProperties] class PostRepository implements PostRepositoryInterface
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
                'post_id' => $post->getPostId(),
                'title' => $post->getTitle(),
                'content' => $post->getContent(),
                'image' => $post->getImage()?->getImageName(),
                'link' => $post->getLink(),
                'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
                'user_id' => $post->getUser()->getUserId()
            ]);
        $this->client->pushWithoutResults($builder->getInsertQuery());
    }

    public function getPosts(): array
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select(
                "post.post_id, 
            post.title, 
            post.content, 
            post.image, 
            post.link, 
            post.created_at, 
            user.user_name, 
            user.avatar")
            ->from('post')
            ->join('user', 'post.user_id = user.user_id')
            ->orderBy("post.created_at", "DESC");
        return $this->client->getResults($builder->getSelectQuery());
    }

    public function getPost(string $postID): array
    {
        $builder = $this->client
            ->createQueryBuilder()
            ->select(
                "post.post_id, 
            post.title, 
            post.content, 
            post.image, 
            post.link, 
            post.created_at, 
            user.user_name, 
            user.avatar")
            ->from('post')
            ->join('user', 'post.user_id = user.user_id')
            ->where('post.post_id', '=', $postID);
        return $this->client->getResults($builder->getSelectQuery());
    }
}