<?php

namespace app\Core\HTTP\Response\ErrorResponses;

use app\Core\HTTP\Enum\CodeStatus;
use app\Core\HTTP\Enum\ContentType;
use app\Core\HTTP\Response\Response;
use app\Util\View;

class PageNotFoundResponse extends Response
{
    public function __construct()
    {
        parent::__construct(View::make('error/404.html'), ContentType::text, CodeStatus::NotFound->value);
    }

}