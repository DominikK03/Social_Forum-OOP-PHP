<?php

namespace app\Core\HTTP\Response;

use app\Core\HTTP\Enum\ContentType;

class HtmlResponse extends Response
{
    public function __construct(string $content)
    {
        parent::__construct($content, ContentType::text);
    }
}