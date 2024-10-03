<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\JsonResponse;
use app\Core\HTTP\Response\RedirectResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Exception\PasswordDoesntMatchException;
use app\Exception\UserDoesntExistException;
use app\Repository\LoginRepository;
use app\Request\LoginDataRequest;
use app\Request\LoginPageRequest;
use app\Service\LoginService;
use app\Util\TemplateRenderer;
use app\View\LoginView;

#[AllowDynamicProperties] class LoginController
{
    public function __construct(TemplateRenderer $renderer,LoginService $service, LoginRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
        $this->renderer = $renderer;
        $this->loginView = new LoginView();
    }

    #[Route('/login', 'GET')]
    public function loginView(LoginPageRequest $request) : ResponseInterface
    {
        return new HtmlResponse($this->loginView->renderWithRenderer($this->renderer));
    }

    #[Route('/login', 'POST')]
    public function handleLogin(LoginDataRequest $request) : ResponseInterface
    {
        try {
            $user = $this->repository->handleLogin(
                $this->service->verifyUser($request->getName(), $request->getPassword())
            );
            $userData = array(
                'userid'=>$user->getUserId(),
                'username'=>$user->getUsername(),
                'email'=>$user->getEmail(),
                'passwordHash'=>$user->getPasswordHash(),
                'createdAt'=>$user->getCreatedAt(),
                'role'=>$user->getRole()
            );
            foreach ($userData as $key => $value){
                $_SESSION[$key]=$value;
            }
            return new RedirectResponse('/',$_SESSION);

        }catch (UserDoesntExistException $e){
            return new JsonResponse(['success'=>false, 'message' => $e->getMessage()]);
        }catch (PasswordDoesntMatchException $e){
            return new JsonResponse(['success'=>false, 'message' => $e->getMessage()]);
        }
    }

}