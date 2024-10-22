<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;

#[AllowDynamicProperties] class PostRequest extends Request implements RequestInterface
{
    private ?array $image;
    private ?string $imageTmpName;
    private ?string $imageType;
    private ?int $imageSize;

    private string $postID;
    private string $postTitle;
    private ?string $postContent = null;
    private ?string $postLink = null;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function fromRequest()
    {
        if ($this->request->getFiles() !== null) {
            $this->image = $this->request->getFiles();
            $this->imageTmpName = $this->request->getFileParam('image', 'tmp_name');
            $this->imageType = $this->request->getFileParam('image', 'type');
            $this->imageSize = $this->request->getFileParam('image', 'size');
        }
        if (!empty($this->request->getRequest())) {
            $this->postTitle = htmlspecialchars($this->request->getRequestParam('postTitle'));
            $this->postContent = htmlspecialchars($this->request->getRequestParam('postContent'));
        }
        if (!empty($this->request->getQuery())) {
            $this->postID = $this->request->getQueryParams('postID');
        }
        if (!is_null($this->request->getRequestParam('postLink'))){
            $this->postLink = htmlspecialchars($this->request->getRequestParam('postLink'));
        }

    }


    /**
     * @return array|null
     */
    public function getImage(): ?array
    {
        return $this->image;
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

    /**
     * @return string
     */
    public function getPostID(): string
    {
        return $this->postID;
    }

}