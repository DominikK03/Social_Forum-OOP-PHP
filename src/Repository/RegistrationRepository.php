<?php

namespace app\Repository;

use AllowDynamicProperties;
use app\mysqlClient;
use app\Exception\EmailAlreadyExistsException;
use app\Exception\UsernameAlreadyExistsException;
use app\Model\User;

#[AllowDynamicProperties]
class RegistrationRepository
{
    public function __construct(mysqlClient $DB)
    {
        $this->db = $DB;
    }


    public function registerUser(User $user)
    {
        $this->db->insert('user', [
            'user_id' => $user->getUserId(),
            'user_name' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password_hash' => $user->getPasswordHash(),
            'role' => $user->getRole(),
            'created_at' => $user->getCreatedAt()
        ]);
    }

}