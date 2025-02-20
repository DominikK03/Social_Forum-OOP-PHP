<?php

namespace app\Service\Validator;

use AllowDynamicProperties;
use app\Repository\Auth\AuthRepositoryInterface;

#[AllowDynamicProperties]
class RegistrationValidator
{
    public function __construct(AuthRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    public function validateRegistration(string $username, string $email)
    {
        $this->repository->verifyUsernameExistence($username);
        $this->repository->verifyEmailExistence($email);
    }
    public function validateLogin(string $username, string $password)
    {
        $this->repository->verifyUsernameExistence($username);
        $this->repository->verifyPasswordCorrectness($username, $password);
    }
}