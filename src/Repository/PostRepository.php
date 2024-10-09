<?php

namespace app\Repository;

use AllowDynamicProperties;
use app\Model\Post;
use app\MysqlClient;

#[AllowDynamicProperties] class PostRepository
{
    public function __construct(MysqlClient $client)
    {
        $this->client = $client;
    }

    public function insertPost(Post $post)
    {
        $builder = $this->client->createQueryBuilder();
        $builder->insert('post', [
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
}