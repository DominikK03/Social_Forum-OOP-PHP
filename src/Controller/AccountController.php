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
use app\Repository\AccountRepository;
use app\Request\AccountRequest;
use app\Service\AccountService;
use app\Service\AuthService;
use app\Util\TemplateRenderer;
use app\View\AccountView;

#[AllowDynamicProperties] class AccountController
{
    public function __construct(TemplateRenderer  $renderer,
                                AuthService       $authService,
                                AccountService    $accountService,
                                AccountRepository $accountRepository)
    {
        $this->authService = $authService;
        $this->accountService = $accountService;
        $this->accountRepository = $accountRepository;
        $this->accountView = new AccountView();
        $this->renderer = $renderer;
    }

    #[Route('/account', 'GET')]
    public function accountView(AccountRequest $request): ResponseInterface
    {
        if ($this->authService->isLoggedIn()) {
            return new HtmlResponse($this->accountView->renderWithRenderer($this->renderer));
        } else {
            return new RedirectResponse('/', ['loginStatus' => 'not-logged-in']);
        }
    }

    #[Route('/passwordChange', 'POST')]
    public function passwordChange(AccountRequest $request) : ResponseInterface
    {
        try {
            $this->accountRepository->updatePassword(
                $this->accountService->validateData(
                    $request->getName(),
                    $request->getPassword()),
                    $request->getNewPassword()
            );
        } catch (PasswordDoesntMatchException) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid password']);
        }
        return new JsonResponse(['success'=>true]);

    }

}