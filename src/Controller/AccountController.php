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
use app\Repository\AccountRepositoryInterface;
use app\Repository\ImageRepositoryInterface;
use app\Request\AccountRequest;
use app\Service\AccountService;
use app\Service\AuthService;
use app\Service\ImageService;
use app\Util\TemplateRenderer;
use app\View\AccountView;

#[AllowDynamicProperties] class AccountController
{
    public function __construct(
        TemplateRenderer           $renderer,
        AuthService                $authService,
        AccountService             $accountService,
        AccountRepositoryInterface $accountRepository,
        ImageRepositoryInterface   $imageRepository,
        ImageService               $imageService)
    {
        $this->authService = $authService;
        $this->accountService = $accountService;
        $this->accountRepository = $accountRepository;
        $this->renderer = $renderer;
        $this->imageRepository = $imageRepository;
        $this->imageService = $imageService;
    }

    #[Route('/account', 'GET', [Role::user, Role::admin])]
    public function accountView(AccountRequest $request): ResponseInterface
    {
        if ($this->authService->isLoggedIn()) {
            $accountView = new AccountView([
                '{{Username}}' => $request->getName(),
                '{{Email}}' => $request->getEmail(),
                '{{CreatedAt}}' => $request->getCreatedAt(),
                '{{Avatar}}' => $this->accountRepository->getUserAvatar($request->getName())
            ]);
            return new HtmlResponse($accountView->renderWithRenderer($this->renderer));
        } else {
            return new RedirectResponse('/', ['loginStatus' => 'not-logged-in']);
        }
    }

    #[Route('/admin', 'GET', [Role::admin])]
    public function adminView(AccountRequest $request): ResponseInterface
    {
        echo 'hellow';

    }

    #[Route('/passwordChange', 'POST', [Role::user, Role::admin])]
    public function passwordChange(AccountRequest $request): ResponseInterface
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
        return new JsonResponse(['success' => true]);
    }

    #[Route('/setAvatarImage', 'POST', [Role::user, Role::admin])]
    public function setAvatarImage(AccountRequest $request): ResponseInterface
    {
        try {
            $avatar = $this->imageService->setImageData(
                "avatar-" . $request->getName() . "."
                . str_replace('image/', '', $request->getImageType()),
                $request->getImageTmpName(),
                $request->getImageType(),
                $request->getImageSize());
            $this->imageRepository->deleteAvatar($avatar->getImageName());
            $this->accountRepository->setAvatar($avatar, $request->getName());
            $this->imageRepository->uploadAvatar($avatar);

        } catch (FileIsntImageException) {
            return new JsonResponse(['success' => false]);
        } catch (NotProperSizeException) {
            return new JsonResponse(['success' => false]);
        }
        return new JsonResponse(['success' => true]);
    }

}