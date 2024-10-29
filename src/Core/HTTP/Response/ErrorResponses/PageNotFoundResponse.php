<?php

namespace app\Core\HTTP\Response\ErrorResponses;

use app\Core\HTTP\Enum\CodeStatus;
use app\Core\HTTP\Enum\ContentType;
use app\Core\HTTP\Response\Response;
class PageNotFoundResponse extends Response
{
    public function __construct(string $content)
    {
        parent::__construct($content, ContentType::text, CodeStatus::NotFound->value);
    }

}