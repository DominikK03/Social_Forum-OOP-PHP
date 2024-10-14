<?php

namespace app\Service;

use AllowDynamicProperties;
use app\Factory\UserFactory;
use app\Model\User;
use app\MysqlClient;
use app\MysqlClientInterface;
use app\Repository\AuthRepository;
use app\Repository\AuthRepositoryInterface;
use app\Service\Validator\RegistrationValidator;

#[AllowDynamicProperties] class AuthService
{
    public function __construct(
        AuthRepositoryInterface $repository,
        UserFactory             $factory,
        RegistrationValidator   $validator)
    {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->validator = $validator;

    }

    public function setUserData(string $username, string $email, string $password): User
    {
        $this->validator->validate($username, $email);
        return $this->factory->createUser($username, $email, $password);
    }

    public function loginUser(string $username, string $password)
    {
        $this->repository->verifyLoginRequest($username, $password);
        $user = $this->repository->findByUsername($username);
        $_SESSION['user'] = [
            'userid' => $user->getUserId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'passwordHash' => $user->getPasswordHash(),
            'createdAt' => $user->getCreatedAt(),
            'role' => $user->getRole(),
        ];
    }

    public function logoutUser()
    {
        unset($_SESSION['user']);
        session_destroy();
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user']);
    }


}