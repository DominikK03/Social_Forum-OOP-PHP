<?php

namespace app\Factory;

use app\Model\Image;
use app\Model\Post;
use app\Model\User;
use DateTime;
use Ramsey\Uuid\Uuid;

class PostFactory
{
    public function createPost(
        string  $title,
        User    $user,
        Image   $image = null,
        ?string $content,
        ?string $link): Post
    {
        return new Post(Uuid::uuid4(), $title, new DateTime(), $user, $image, $content, $link);
    }

}