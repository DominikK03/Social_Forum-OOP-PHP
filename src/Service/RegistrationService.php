<?php

namespace app\Service;

use AllowDynamicProperties;
use app\Factory\UserFactory;
use app\Model\User;
use app\Repository\RegistrationRepository;

#[AllowDynamicProperties] class RegistrationService
{
    public function __construct(UserFactory $factory, RegistrationRepository $repository)
    {
        $this->factory = $factory;
        $this->repository = $repository;
    }

    public function setUserData(string $username, string $email, string $password) : User
    {
        $this->repository->assertEmailExists($email);
        $this->repository->assertUsernameExists($username);
        return $this->factory->createUser($username,$email,$password);
    }

}