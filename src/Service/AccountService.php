<?php

namespace app\Service;

use AllowDynamicProperties;
use app\Model\User;
use app\Repository\AuthRepository;
use app\Repository\AuthRepositoryInterface;
use app\Util\StaticValidator;

#[AllowDynamicProperties] class AccountService
{
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function validateData(string $username, string $password) : User
    {
        $user = $this->authRepository->findByUsername($username);
        StaticValidator::assertConfirmPassword($password, $user->getPasswordHash());
        return $user;
    }
}