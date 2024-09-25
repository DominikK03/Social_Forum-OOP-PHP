<?php

namespace app\Model;

use DateTime;
use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class Comment
{
    public function __construct(private UuidInterface     $commentId,
                                private string            $content,
                                private DateTimeInterface $createdAt,
                                private User              $user)
    {
    }

    /**
     * @return UuidInterface
     */
    public function getCommentId(): UuidInterface
    {
        return $this->commentId;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}