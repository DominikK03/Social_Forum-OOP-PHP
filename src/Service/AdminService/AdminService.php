<?php

namespace app\Service\AdminService;

use AllowDynamicProperties;
use app\Enum\Role;
use app\Repository\Admin\AdminRepository;
use app\Repository\Admin\AdminRepositoryInterface;
use app\Repository\Auth\AuthRepository;
use app\Repository\Auth\AuthRepositoryInterface;
use app\Repository\Post\PostRepository;
use app\Repository\Post\PostRepositoryInterface;
use app\Service\Image\ImageService;
use app\Service\Validator\RoleChangeValidator;

#[AllowDynamicProperties] class AdminService
{
    public function __construct(
        AdminRepositoryInterface $adminRepository,
        AuthRepositoryInterface $authRepository,
        RoleChangeValidator $roleChangeValidator,
        ImageService $imageService,
        PostRepositoryInterface $postRepository
    )
    {
        $this->adminRepository = $adminRepository;
        $this->authRepository = $authRepository;
        $this->roleChangeValidator = $roleChangeValidator;
        $this->imageService = $imageService;
        $this->postRepository = $postRepository;
    }

    public function changeUserRole(string $username, Role $role)
    {
        $user = $this->authRepository->findByUsername($username);
        $this->roleChangeValidator->validate($user);
        $this->adminRepository->updateUserRole($user, $role);
    }
    public function deletePostByID(string $deletePostID)
    {
        $post = $this->postRepository->getPost($deletePostID);
        if ($post['image'] != ''){
            $this->imageService->imageRepository->deleteImage($post['image']);
        }
        $this->adminRepository->deletePost($post['post_id']);
    }
}