<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\JsonResponse;
use app\Core\HTTP\Response\RedirectResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Enum\Role;
use app\Exception\EmailAlreadyExistsException;
use app\Exception\PasswordDoesntMatchException;
use app\Exception\UserDoesntExistException;
use app\Exception\UsernameAlreadyExistsException;
use app\Request\LoginRequest;
use app\Request\LogoutRequest;
use app\Request\RegistrationRequest;
use app\Service\Auth\AuthService;
use app\Util\TemplateRenderer;
use app\View\Authentication\LoginView;
use app\View\Authentication\RegisterView;

#[AllowDynamicProperties] class AuthController
{
    public function __construct(
        TemplateRenderer        $renderer,
        AuthService             $authService,
        )
    {
        $this->authService = $authService;
        $this->renderer = $renderer;

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    #[Route('/register', 'GET')]
    public function registrationView(RegistrationRequest $request): ResponseInterface
    {
        $registerView = new RegisterView();
        return new HtmlResponse($registerView->renderWithRenderer($this->renderer));
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
        } catch (EmailAlreadyExistsException) {
            return new JsonResponse(['success' => false, 'message' => 'E-mail already exists']);
        } catch (UsernameAlreadyExistsException) {
            return new JsonResponse(['success' => false, 'message' => 'Username already exists']);
        }
        return new JsonResponse(['success' => true]);
    }

    #[Route('/login', 'GET')]
    public function loginView(LoginRequest $request): ResponseInterface
    {
        $loginView = new LoginView();
        return new HtmlResponse($loginView->renderWithRenderer($this->renderer));
    }

    #[Route('/login', 'POST')]
    public function handleLogin(LoginRequest $request): ResponseInterface
    {
        try {
            $loginUser = $this->authService->loginUser(
                $request->getName(),
                $request->getPassword()
            );
            return new JsonResponse(['success' => true, 'role' => $loginUser->getRole()->name]);

        } catch (UserDoesntExistException $e) {
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()]);
        } catch (PasswordDoesntMatchException $e) {
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    #[Route('/logout', 'GET', [Role::user, Role::admin, Role::master])]
    public function logout(LogoutRequest $request): ResponseInterface
    {
        $this->authService->logoutUser();
        return new RedirectResponse('/login', ['loginStatus' => 'logout']);
    }

}