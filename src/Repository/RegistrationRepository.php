<?php

namespace app\Repository;

use AllowDynamicProperties;
use app\DB;
use app\Exception\EmailAlreadyExistsException;
use app\Exception\UsernameAlreadyExistsException;
use app\Model\User;

#[AllowDynamicProperties]
class RegistrationRepository
{
    public function __construct(DB $DB)
    {
        $this->db = $DB;
    }

    public function assertEmailExists(string $email)
    {
        $this->db->query('SELECT email FROM user');
        if ($email == $this->db->single())
        {
            throw new EmailAlreadyExistsException();
        }
    }
    public function assertUsernameExists(string $username)
    {
        $this->db->query('SELECT user_name FROM user');
        if ($username == $this->db->single())
        {
            throw new UsernameAlreadyExistsException();
        }

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