<?php

namespace app\Model;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
const COMMENT = 'comment';
readonly class Comment
{
    public function __construct(
        public UuidInterface $commentId,
        public string $content,
        public DateTimeInterface $createdAt,
        public User $user,
        public string $currentPostID
    )
    {
    }

}