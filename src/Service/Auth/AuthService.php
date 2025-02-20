<?php

namespace app\Service\Auth;

use AllowDynamicProperties;
use app\Exception\PasswordDoesntMatchException;
use app\Exception\UserDoesntExistException;
use app\Factory\UserFactory;
use app\Model\User;
use app\Repository\Auth\AuthRepositoryInterface;
use app\Service\Validator\RegistrationValidator;
use app\Util\SessionManager;
use app\Util\StaticValidator;
use Ramsey\Uuid\Uuid;

#[AllowDynamicProperties]
class AuthService
{
    public function __construct(
        AuthRepositoryInterface $authRepository,
        UserFactory $userFactory,
        RegistrationValidator $registrationValidator,
        SessionManager $sessionManager
    )
    {
        $this->authRepository = $authRepository;
        $this->userFactory = $userFactory;
        $this->registrationValidator = $registrationValidator;
        $this->sessionManager = $sessionManager;
    }
    public function createUser(string $username, string $email, string $password)
    {
        $this->registrationValidator->validateRegistration($username, $email);
        $this->authRepository->registerUser(
            $this->userFactory->fromUserInput($username, $email, $password)
        );
    }
    public function loginUser(string $username, string $password): User
    {
        $this->registrationValidator->validateLogin($username, $password);
        $user = $this->authRepository->findByUsername($username);
        $this->sessionManager->createSession(User::USER, [
            User::USERID => $user->getUserId(),
            User::USERNAME => $user->getUsername(),
            User::EMAIL => $user->getEmail(),
            User::PASSWORD_HASH => $user->getPasswordHash(),
            User::CREATED_AT => $user->getCreatedAt(),
            User::ROLE => $user->getRole(),
        ]);
        return $user;
    }
    public function logoutUser()
    {
        $this->sessionManager->unsetSession(User::USER);
        session_destroy();
    }
    public function isLoggedIn()
    {
       return $this->sessionManager->issetSession(User::USER);
    }
    public function getLoggedInUser(array $userData): User
    {
        return new User(
            Uuid::fromString($userData[User::USERID]),
            $userData[User::USERNAME],
            $userData[User::EMAIL],
            $userData[User::PASSWORD_HASH],
            $userData[User::CREATED_AT],
            $userData[User::ROLE]
        );
    }
}