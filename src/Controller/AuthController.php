<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\JsonResponse;
use app\Core\HTTP\Response\RedirectResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Exception\EmailAlreadyExistsException;
use app\Exception\PasswordDoesntMatchException;
use app\Exception\UserDoesntExistException;
use app\Exception\UsernameAlreadyExistsException;
use app\Repository\AuthRepository;
use app\Request\LoginRequest;
use app\Request\LogoutRequest;
use app\Request\RegistrationRequest;
use app\Service\AuthService;
use app\Util\TemplateRenderer;
use app\View\LoginView;
use app\View\RegisterView;

#[AllowDynamicProperties] class AuthController
{
    public function __construct(TemplateRenderer $renderer, AuthService $service, AuthRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->renderer = $renderer;
        $this->loginView = new LoginView();
        $this->registerView = new RegisterView();
        if (session_status()=== PHP_SESSION_NONE){
            session_start();
        }
    }

    #[Route('/register', 'GET')]
    public function registrationView(RegistrationRequest $request): ResponseInterface
    {
        return new HtmlResponse($this->registerView->renderWithRenderer($this->renderer));
    }

    #[Route('/register', 'POST')]
    public function handleRegistration(RegistrationRequest $request): ResponseInterface
    {
        try {
            $this->repository->registerUser(
                $this->service->setUserData(
                    $request->getName(),
                    $request->getEmail(),
                    $request->getPassword()
                ));
        } catch (EmailAlreadyExistsException) {
            return new JsonResponse(['success' => false, 'message' => 'E-mail already exists']);
        } catch (UsernameAlreadyExistsException) {
            return new JsonResponse(['success' => false, 'message' => 'Username already exists']);
        }
        return new JsonResponse(['success' => true]);
    }

    #[Route('/login', 'GET')]
    public function loginView(LoginRequest $request) : ResponseInterface
    {
        return new HtmlResponse($this->loginView->renderWithRenderer($this->renderer));
    }

    #[Route('/login', 'POST')]
    public function handleLogin(LoginRequest $request) : ResponseInterface
    {
        try {
            $this->service->loginUser($request->getName(), $request->getPassword());
        }catch (UserDoesntExistException $e){
            return new JsonResponse(['success'=>false, 'message' => $e->getMessage()]);
        }catch (PasswordDoesntMatchException $e){
            return new JsonResponse(['success'=>false, 'message' => $e->getMessage()]);
        }
        return new JsonResponse(['success'=>true]);
    }
    #[Route('/logout', 'GET')]
    public function logout(LogoutRequest $request) : ResponseInterface
    {
        $this->service->logoutUser();
        return new RedirectResponse('/',['loginStatus'=>'logout']);
    }

}