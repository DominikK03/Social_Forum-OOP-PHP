<?php

namespace app\Service;

use AllowDynamicProperties;
use app\Factory\UserFactory;
use app\Model\User;
use app\MysqlClient;
use app\Repository\AuthRepository;
use app\Util\StaticValidator;

#[AllowDynamicProperties] class AuthService
{
    public function __construct(MysqlClient $client,
                                AuthRepository $repository,
                                UserFactory $factory,
                                RegistrationValidator $validator)
    {
        $this->client = $client;
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
        StaticValidator::verifyLoginRequest($username, $password, $this->client);
        $user = $this->repository->findByUsername($username);
        $_SESSION['user'] = [
            'userid'=>$user->getUserId(),
            'username'=>$user->getUsername(),
            'email'=>$user->getEmail(),
            'passwordHash'=>$user->getPasswordHash(),
            'createdAt'=>$user->getCreatedAt(),
            'role'=>$user->getRole()
        ];
    }
    public function logoutUser() {
        unset($_SESSION['user']);
        session_destroy();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }

    public function getLoggedUser() {
        return $_SESSION['user'] ?? null;
    }

}