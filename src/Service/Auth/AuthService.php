<?php

namespace app\Service\Auth;

use AllowDynamicProperties;
use app\Enum\Role;
use app\Factory\UserFactory;
use app\Model\User;
use app\Repository\Auth\AuthRepositoryInterface;
use app\Service\Validator\RegistrationValidator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[AllowDynamicProperties] class AuthService
{
    public function __construct(
        AuthRepositoryInterface $authRepository,
        UserFactory             $userFactory,
        RegistrationValidator   $registrationValidator)
    {
        $this->authRepository = $authRepository;
        $this->userFactory = $userFactory;
        $this->registrationValidator = $registrationValidator;

    }

    public function createUser(string $username, string $email, string $password)
    {
        $this->registrationValidator->validate($username, $email);
        $this->authRepository->registerUser(
            $this->userFactory->fromUserInput($username, $email, $password)
        );
    }

    public function loginUser(string $username, string $password)
    {
        $this->authRepository->verifyLoginRequest($username, $password);
        $user = $this->authRepository->findByUsername($username);
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

    public function getLoggedInUser(array $userData): User
    {
        return new User(
            Uuid::fromString($userData['userid']),
            $userData['username'],
            $userData['email'],
            $userData['passwordHash'],
            $userData['createdAt'],
            $userData['role']
        );

    }


}