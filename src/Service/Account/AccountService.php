<?php

namespace app\Service\Account;

use AllowDynamicProperties;
use app\Model\Image;
use app\Model\User;
use app\Repository\Account\AccountRepositoryInterface;
use app\Repository\Auth\AuthRepositoryInterface;
use app\Service\Image\ImageService;
use app\Util\StaticValidator;

#[AllowDynamicProperties] class AccountService
{
    public function __construct(
        AuthRepositoryInterface $authRepository,
        AccountRepositoryInterface $accountRepository,
        ImageService $imageService
    )
    {
        $this->authRepository = $authRepository;
        $this->accountRepository = $accountRepository;
        $this->imageService = $imageService;
    }

    public function changePassword(string $username, string $password, string $newPassword)
    {
        $user = $this->authRepository->findByUsername($username);
        StaticValidator::assertConfirmPassword($password, $user->getPasswordHash());
        $this->accountRepository->updatePassword($user, $newPassword);
    }

    public function setAvatar(Image $image, string $username)
    {
        $this->imageService->updateAvatar($image);
        $this->accountRepository->insertAvatarImage($image, $username);
    }
    public function deleteAccountWithConfirmation(User $user, string $deletePassword)
    {
        StaticValidator::assertConfirmPasswordDelete($deletePassword, $user->getPasswordHash());
        $this->accountRepository->deleteImagesAssignedToAccount($user);
        $this->accountRepository->deleteAccount($user);
    }
}