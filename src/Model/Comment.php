<?php

namespace app\Model;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

class Comment
{
    public function __construct(
        private UuidInterface     $commentId,
        private string            $content,
        private DateTimeInterface $createdAt,
        private User              $user,
        private string            $currentPostID)
    {
    }

    /**
     * @return UuidInterface
     */
    public
    function getCommentId(): UuidInterface
    {
        return $this->commentId;
    }

    /**
     * @return DateTimeInterface
     */
    public
    function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public
    function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return User
     */
    public
    function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getCurrentPostId(): string
    {
        return $this->currentPostID;
    }
}