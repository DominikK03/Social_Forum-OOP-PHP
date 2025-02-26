<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\ErrorResponses\LogoutRedirectResponse;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Core\HTTP\Response\SuccessfullResponse;
use app\Core\HTTP\Response\UnsuccessfullResponse;
use app\Enum\Role;
use app\Exception\EmailAlreadyExistsException;
use app\Exception\PasswordDoesntMatchException;
use app\Exception\UserDoesntExistException;
use app\Exception\UsernameAlreadyExistsException;
use app\Request\LoginRequest;
use app\Request\LogoutRequest;
use app\Request\RegistrationRequest;
use app\Service\Auth\AuthService;
use app\Util\SessionManager;
use app\Util\TemplateRenderer;
use app\View\ViewFactory;

#[AllowDynamicProperties]
class AuthController
{
    public function __construct(
        TemplateRenderer $renderer,
        AuthService $authService,
        SessionManager $sessionManager,
    )
    {
        $this->authService = $authService;
        $this->renderer = $renderer;
        $this->sessionManager = $sessionManager;
        $this->sessionManager->startSession();
    }
    #[Route('/register', 'GET')]
    public function registrationView(RegistrationRequest $request): ResponseInterface
    {
        return new HtmlResponse(
            ViewFactory::createRegistrationView()
                ->renderWithRenderer($this->renderer)
        );
    }
    #[Route('/register', 'POST')]
    public function handleRegistration(RegistrationRequest $request): ResponseInterface
    {
        try {
            $this->authService->createUser(
                $request->getName(),
                $request->getEmail(),
                $request->getPassword()
            );
            return new SuccessfullResponse();
        } catch (EmailAlreadyExistsException $e) {
            return new UnsuccessfullResponse(['message' => $e->getMessage()]);
        } catch (UsernameAlreadyExistsException $e) {
            return new UnsuccessfullResponse(['message' => $e->getMessage()]);
        }
    }
    #[Route('/login', 'GET')]
    public function loginView(LoginRequest $request): ResponseInterface
    {
        return new HtmlResponse(
           ViewFactory::createLoginView()
                ->renderWithRenderer($this->renderer)
        );
    }
    #[Route('/login', 'POST')]
    public function handleLogin(LoginRequest $request): ResponseInterface
    {
        try {
            $loginUser = $this->authService->loginUser(
                $request->getName(),
                $request->getPassword()
            );
            return new SuccessfullResponse(['role' => $loginUser->getRole()->name]);
        } catch (UserDoesntExistException $e) {
            return new UnsuccessfullResponse(['message' => $e->getMessage()]);
        } catch (PasswordDoesntMatchException $e) {
            return new UnsuccessfullResponse(['message' => $e->getMessage()]);
        }
    }
    #[Route('/logout', 'GET', [Role::user])]
    public function logout(LogoutRequest $request): ResponseInterface
    {
        $this->authService->logoutUser();
        return new LogoutRedirectResponse();
    }
}