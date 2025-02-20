<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;
use app\Enum\Role;

#[AllowDynamicProperties]
class AdminRequest
{
    private string $username;
    private Role $role;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function fromRequest()
    {
        if ($this->request->getRequest()) {
            $this->username = $this->request->getRequestParam('username');
            $this->role = Role::from($this->request->getRequestParam('role'));
        }
    }
    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }
}