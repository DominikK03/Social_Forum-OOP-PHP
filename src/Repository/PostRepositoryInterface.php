<?php

namespace app\Repository;

use app\Model\Post;

interface PostRepositoryInterface
{
    public function insertPost(Post $post);
    public function getPosts(): array;
    public function getPost(string $postID): array;


}