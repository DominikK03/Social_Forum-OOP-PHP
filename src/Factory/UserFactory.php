<?php

namespace app\Factory;

use app\Model\User;
use DateTime;
use Ramsey\Uuid\Uuid;

class UserFactory
{
    public function fromUserInput(string $username, string $email, string $password): User
    {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        return new User(Uuid::uuid4(), $username, $email, $passwordHash, new DateTime());
    }
}