<?php

namespace app\Core\HTTP\Response;

use app\Core\HTTP\Enum\ContentType;

class JsonResponse extends Response
{
    public function __construct(array $data)
    {
        $jsonData = json_encode($data);
        parent::__construct($jsonData, ContentType::application);
    }
}
