<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;

#[AllowDynamicProperties] class PostRequest
{
    private ?string $imageTmpName;
    private ?string $imageType;
    private ?int $imageSize;

    private string $postTitle;
    private ?string $postContent = null;
    private ?string $postLink = null;



    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function fromRequest(): void
    {
        $this->imageTmpName = $this->request->getFileParam('image', 'tmp_name');
        $this->imageType = $this->request->getFileParam('image', 'type');
        $this->imageSize = $this->request->getFileParam('image', 'size');
        $this->postTitle = $this->request->getRequestParam('postTitle');
        $this->postContent = $this->request->getRequestParam('postContent');
    }

    public function getImageTmpName(): string
    {
        return $this->imageTmpName;
    }

    public function getImageType(): string
    {
        return $this->imageType;
    }

    public function getImageSize(): int
    {
        return $this->imageSize;
    }

    /**
     * @return string
     */
    public function getPostTitle(): string
    {
        return $this->postTitle;
    }

    /**
     * @return string|null
     */
    public function getPostContent(): ?string
    {
        return $this->postContent;
    }

    /**
     * @return string|null
     */
    public function getPostLink(): ?string
    {
        return $this->postLink;
    }

}