<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;

#[AllowDynamicProperties]
class MainPageRequest extends Request
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function fromRequest()
    {
    }
}