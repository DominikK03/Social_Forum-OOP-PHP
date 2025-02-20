<?php

namespace app\Repository\Auth;

use app\Model\User;

interface AuthRepositoryInterface
{
    public function registerUser(User $user);
    public function findByUsername(string $username): ?User;
    public function verifyUsernameExistence(string $username): void;
    public function verifyEmailExistence(string $email): void;
    public function verifyPasswordCorrectness(string $username, string $password);
}