<?php

namespace app\Core\HTTP\Response;
use app\Core\HTTP\Response\JsonResponse;

class UnsuccessfullResponse extends JsonResponse
{
    public function __construct(array $data = [])
    {
        parent::__construct(array_merge(['success' => false], $data));
    }
}