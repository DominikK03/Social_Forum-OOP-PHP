<?php

namespace app\Model;

use DateTime;
use DateTimeInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

const POST = 'post';
class Post
{
    public function __construct(
        private UuidInterface $postId,
        private string $title,
        private DateTimeInterface $createdAt,
        private User $user,
        private ?Image $image,
        private ?string $content = null,
        private ?string $link = null
    )
    {
    }
    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }
    /**
     * @return UuidInterface
     */
    public function getPostId(): UuidInterface
    {
        return $this->postId;
    }
    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
    /**
     * @return Image|null
     */
    public function getImage(): ?Image
    {
        return $this->image;
    }
    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}