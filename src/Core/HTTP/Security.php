<?php

namespace app\Core\HTTP;
use app\Enum\Role;
use app\Exception\AccessDeniedException;

class Security
{
    private const ROLE_HIERARCHY = [
        Role::master->name => [Role::admin],
        Role::admin->name => [Role::user],
        Role::user->name => []
    ];

    public static function assertAccess(Role $userRole, array $requiredRoles): void
    {
        $grantedRoles = self::getInheritedRoles($userRole);

        foreach ($requiredRoles as $requiredRole) {
            if (in_array($requiredRole, $grantedRoles, true)) {
                return;
            }
        }

        throw new AccessDeniedException();
    }

    private static function getInheritedRoles(Role $role): array
    {
        $roles = [$role];

        while (!empty(self::ROLE_HIERARCHY[$role->name])) {
            $role = self::ROLE_HIERARCHY[$role->name][0];
            $roles[] = $role;
        }

        return $roles;
    }
}
