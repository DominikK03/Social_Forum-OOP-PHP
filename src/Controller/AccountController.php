<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\JsonResponse;
use app\Core\HTTP\Response\RedirectResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Enum\Role;
use app\Exception\FileIsntImageException;
use app\Exception\NotProperSizeException;
use app\Exception\PasswordDoesntMatchException;
use app\Exception\WrongPasswordException;
use app\Repository\Account\AccountRepositoryInterface;
use app\Request\AccountRequest;
use app\Service\Account\AccountService;
use app\Service\Auth\AuthService;
use app\Service\Image\ImageService;
use app\Util\TemplateRenderer;
use app\View\Account\AccountInfoView;
use app\View\Account\AccountView;
use app\View\Admin\AdminNavbarView;
use app\View\Util\NavbarView;

#[AllowDynamicProperties] class AccountController
{
    public function __construct(
        TemplateRenderer           $renderer,
        AuthService                $authService,
        AccountService             $accountService,
        AccountRepositoryInterface $accountRepository,
        ImageService               $imageService)
    {
        $this->authService = $authService;
        $this->accountService = $accountService;
        $this->accountRepository = $accountRepository;
        $this->renderer = $renderer;
        $this->imageService = $imageService;
    }

    #[Route('/account', 'GET', [Role::user, Role::admin, Role::master])]
    public function accountView(AccountRequest $request): ResponseInterface
    {
        if ($this->authService->isLoggedIn()) {
            $navbarView = new NavbarView();
            $accountInfoView = new AccountInfoView([
                '{{Username}}' => $request->getUserSession()['username'],
                '{{Email}}' => $request->getUserSession()['email'],
                '{{CreatedAt}}' => $request->getUserSession()['createdAt']->format("Y-m-d H:i:s"),
                '{{Avatar}}' => $this->accountRepository->getUserAvatar($request->getUserSession()['username']),
            ]);
            $accountView = new AccountView($accountInfoView, $navbarView);
            return new HtmlResponse($accountView->renderWithRenderer($this->renderer));
        } else {
            return new RedirectResponse('/', ['loginStatus' => 'not-logged-in']);
        }
    }

    #[Route('/account/passwordChange', 'POST', [Role::user, Role::admin, Role::master])]
    public function passwordChange(AccountRequest $request): ResponseInterface
    {
        try {
            $this->accountService->changePassword(
                $request->getUserSession()['username'],
                $request->getCurrentPassword(),
                $request->getNewPassword()
            );
            return new JsonResponse(['success' => true]);
        } catch (PasswordDoesntMatchException) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid password']);
        }
    }

    #[Route('/account/postAvatar', 'POST', [Role::user, Role::admin, Role::master])]
    public function setAvatarImage(AccountRequest $request): ResponseInterface
    {
        try {
            $this->accountService->setAvatar(
                $this->imageService->createImage(
                    "avatar-" . $request->getUserSession()['username'] . "."
                    . str_replace('image/', '', $request->getImageType()),
                    $request->getImageTmpName(),
                    $request->getImageType(),
                    $request->getImageSize()
                ),
                $request->getUserSession()['username']
            );
            return new JsonResponse(['success' => true]);
        } catch (FileIsntImageException) {
            return new JsonResponse(['success' => false]);
        } catch (NotProperSizeException) {
            return new JsonResponse(['success' => false]);
        }
    }

    #[Route('/account/deleteAccount', 'POST', [Role::user, Role::admin, Role::master])]
    public function deleteAccount(AccountRequest $request): ResponseInterface
    {
        try {
            $this->accountService->deleteAccountWithConfirmation(
                $this->authService->getLoggedInUser(
                    $request->getUserSession()
                ),
                $request->getDeletePassword()
            );
            $this->authService->logoutUser();
            return new JsonResponse(['success' => true]);
        } catch (WrongPasswordException $e) {
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}