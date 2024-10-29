<?php

namespace app\Repository\Admin;

use app\Enum\Role;
use app\Model\User;

interface AdminRepositoryInterface
{
    public function updateUserRole(User $user, Role $role);
    public function deletePost(string $getDeletePostID);
    public function deleteCommentByID(string $commentID);
}