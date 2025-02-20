<?php

namespace app\Core\HTTP\Response;

use app\Core\HTTP\Response\JsonResponse;

class SuccessfullResponse extends JsonResponse
{
    public function __construct(array $data = [])
    {
        parent::__construct(array_merge(['success' => true], $data));
    }
}