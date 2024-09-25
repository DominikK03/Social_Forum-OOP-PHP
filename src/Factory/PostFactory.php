<?php

namespace app\Factory;

use app\Model\Post;
use app\Model\User;
use DateTime;
use Ramsey\Uuid\Uuid;

class PostFactory
{
    public function createPost(string $title,
                               User   $user,
                               string $content = '',
                               string $image = '',
                               string $link = ''): Post
    {
        return new Post(Uuid::uuid4(), $title, new DateTime(), $user, $content, $image, $link);
    }

}