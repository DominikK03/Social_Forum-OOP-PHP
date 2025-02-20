<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\ErrorResponses\InvalidPasswordResponse;
use app\Core\HTTP\Response\ErrorResponses\NotLoggedInRedirectResponse;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Core\HTTP\Response\SuccessfullResponse;
use app\Core\HTTP\Response\UnsuccessfullResponse;
use app\Enum\Role;
use app\Exception\FileIsntImageException;
use app\Exception\NotProperSizeException;
use app\Exception\PasswordDoesntMatchException;
use app\Exception\WrongPasswordException;
use app\Request\AccountRequest;
use app\Service\Account\AccountService;
use app\Service\Auth\AuthService;
use app\Service\Image\ImageService;
use app\Util\TemplateRenderer;
use app\View\ViewFactory;

#[AllowDynamicProperties]
class AccountController
{
    public function __construct(
        TemplateRenderer $renderer,
        AuthService $authService,
        AccountService $accountService,
        ImageService $imageService,
        ViewFactory $viewFactory
    )
    {
        $this->authService = $authService;
        $this->accountService = $accountService;
        $this->renderer = $renderer;
        $this->imageService = $imageService;
        $this->viewFactory = $viewFactory;
    }
    #[Route('/account', 'GET', [Role::user, Role::admin, Role::master])]
    public function accountView(AccountRequest $request): ResponseInterface
    {
        if ($this->authService->isLoggedIn()) {
            $accountView = $this->viewFactory->createAccountView(
                $this->viewFactory->createAccountInfoView([
                    'Username' => $request->getUserSession()['userName'],
                    'Email' => $request->getUserSession()['email'],
                    'CreatedAt' => $request->getUserSession()['createdAt']->format("Y-m-d H:i:s"),
                    'Avatar' => $this->accountService->accountRepository->getUserAvatar($request->getUserSession()['userName'])
                ])
            );
            return new HtmlResponse($accountView->renderWithRenderer($this->renderer));
        } else {
            return new NotLoggedInRedirectResponse();
        }
    }
    #[Route('/account/passwordChange', 'POST', [Role::user, Role::admin, Role::master])]
    public function passwordChange(AccountRequest $request): ResponseInterface
    {
        try {
            $this->accountService->changePassword(
                $request->getUserSession()['userName'],
                $request->getCurrentPassword(),
                $request->getNewPassword()
            );
            return new SuccessfullResponse();
        } catch (PasswordDoesntMatchException) {
            return new InvalidPasswordResponse();
        }
    }
    #[Route('/account/postAvatar', 'POST', [Role::user, Role::admin, Role::master])]
    public function setAvatarImage(AccountRequest $request): ResponseInterface
    {
        try {
            $this->accountService->setAvatar(
               $image = $this->imageService->createAvatarImage(
                    $request->getUserSession()['userName'],
                    $request->getImageTmpName(),
                    $request->getImageType(),
                    $request->getImageSize()
                ),
                $request->getUserSession()['userName']
            );
            return new SuccessfullResponse();
        } catch (FileIsntImageException) {
            return new UnsuccessfullResponse();
        } catch (NotProperSizeException) {
            return new UnsuccessfullResponse();
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
            return new SuccessfullResponse();
        } catch (WrongPasswordException $e) {
            return new InvalidPasswordResponse();
        }
    }
}