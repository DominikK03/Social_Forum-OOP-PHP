<?php

namespace app\Service;

use AllowDynamicProperties;
use app\Factory\UserFactory;
use app\Model\User;
use app\Repository\RegistrationRepository;

#[AllowDynamicProperties] class RegistrationService
{
    public function __construct(UserFactory $factory, RegistrationValidator $validator)
    {
        $this->factory = $factory;
        $this->validator = $validator;
    }

    public function setUserData(string $username, string $email, string $password): User
    {
        $this->validator->validate($username, $email);
        return $this->factory->createUser($username, $email, $password);
    }

}