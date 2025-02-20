<?php

namespace app\Core\HTTP\Response\ErrorResponses;
use app\Core\HTTP\Response\JsonResponse;

class InvalidPasswordResponse extends JsonResponse
{
    public function __construct()
    {
        parent::__construct(['success' => false, 'message' => 'Invalid password']);
    }
}