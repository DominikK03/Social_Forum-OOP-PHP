<?php

namespace app\Repository\Post;

use app\Model\Post;

interface PostRepositoryInterface
{
    public function insertPost(Post $post);
    public function getPosts(): array;
    public function getPost(string $postID): array;
    public function countComments(string $postID): int;



}