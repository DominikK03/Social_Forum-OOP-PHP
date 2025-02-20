<?php

namespace app\Core\HTTP\Response;

use app\Core\HTTP\Enum\ContentType;

class JsonResponse extends Response
{
    public function __construct(array $data)
    {
        parent::__construct(json_encode($data), ContentType::application);
    }
}
