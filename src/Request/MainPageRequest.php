<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;

#[AllowDynamicProperties] class MainPageRequest extends Request
{
    private array $userSession;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function fromRequest()
    {
        if ($this->request->getSession('user') !== null) {
            $this->userSession = $this->request->getSession('user');
        }
    }

    /**
     * @return array
     */
    public function getUserSession(): array
    {
        return $this->userSession;
    }
}