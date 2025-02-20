<?php

namespace app\Core\HTTP\Response;

use app\Core\HTTP\Enum\ContentType;

class Response implements ResponseInterface
{
    public function __construct(
        private string $content,
        private ContentType $contentType,
        private int $statusCode = 200
    ) {}

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContentType(): ContentType
    {
        return $this->contentType;
    }
}
