<?php

namespace app\Service\Validator;

use AllowDynamicProperties;
use app\Repository\Auth\AuthRepositoryInterface;

#[AllowDynamicProperties] class RegistrationValidator
{
    public function __construct(AuthRepositoryInterface $repository)
    {
        $this->repository = $repository;

    }

    public function validate(string $username, string $email)
    {
        $this->repository->verifyUsernameExistence($username);
        $this->repository->verifyEmailExistence($email);
    }

}