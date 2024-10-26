<?php

namespace app\Service\AdminService;

use AllowDynamicProperties;
use app\Enum\Role;
use app\Repository\Admin\AdminRepository;
use app\Repository\Auth\AuthRepository;
use app\Service\Validator\RoleChangeValidator;

#[AllowDynamicProperties] class AdminService
{
    public function __construct(
        AdminRepository $adminRepository,
        AuthRepository $authRepository,
        RoleChangeValidator $roleChangeValidator
    )
    {
        $this->adminRepository = $adminRepository;
        $this->authRepository = $authRepository;
        $this->roleChangeValidator = $roleChangeValidator;
    }

    public function changeUserRole(string $username, Role $role)
    {
        $user = $this->authRepository->findByUsername($username);
        $this->roleChangeValidator->validate($user);
        $this->adminRepository->updateUserRole($user, $role);
    }
}