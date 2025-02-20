<?php

namespace app\Core\HTTP\Response;

use app\Core\HTTP\Enum\ContentType;

interface ResponseInterface
{
    public function getContent(): string;
    public function getStatusCode(): int;
    public function getContentType(): ContentType;
}