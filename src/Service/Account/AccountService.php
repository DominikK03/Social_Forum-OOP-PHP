<?php

namespace app\Service\Account;

use AllowDynamicProperties;
use app\Model\Image;
use app\Model\User;
use app\Repository\Account\MysqlAccountRepositoryInterface;
use app\Repository\Auth\AuthRepositoryInterface;
use app\Service\Image\ImageService;
use app\Service\Validator\AccountDataValidator;
use app\Util\StaticValidator;

#[AllowDynamicProperties]
class AccountService
{
    public function __construct(
        AccountDataValidator $accountDataValidator,
        AuthRepositoryInterface $authRepository,
        MysqlAccountRepositoryInterface $accountRepository,
        ImageService $imageService
    )
    {
        $this->accountDataValidator = $accountDataValidator;
        $this->authRepository = $authRepository;
        $this->accountRepository = $accountRepository;
        $this->imageService = $imageService;
    }
    public function changePassword(string $username, string $password, string $newPassword)
    {
        $user = $this->authRepository->findByUsername($username);
        $this->accountDataValidator->assertPasswordConfirmation($password, $user->getPasswordHash());
        $this->accountRepository->updatePassword($user, $newPassword);
    }
    public function setAvatar(Image $image, string $username)
    {
        $this->imageService->updateAvatar($image);
        $this->accountRepository->insertAvatarImage($image, $username);
    }
    public function deleteAccountWithConfirmation(User $user, string $deletePassword)
    {
        $this->accountDataValidator->assertPasswordConfirmation($deletePassword, $user->getPasswordHash());
        $this->accountRepository->deleteImagesAssignedToAccount($user);
        $this->accountRepository->deleteAccount($user);
    }
}