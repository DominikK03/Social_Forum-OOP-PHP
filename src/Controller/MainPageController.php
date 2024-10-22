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
use app\Repository\Image\ImageRepositoryInterface;
use app\Repository\Post\PostRepositoryInterface;
use app\Request\MainPageRequest;
use app\Request\PostRequest;
use app\Service\Auth\AuthService;
use app\Service\Image\ImageService;
use app\Service\Post\PostService;
use app\Util\TemplateRenderer;
use app\View\MainPage\MainPageView;
use app\View\NavbarView;
use app\View\Post\PostView;

#[AllowDynamicProperties] class MainPageController
{
    public function __construct(
        TemplateRenderer         $renderer,
        AuthService              $authService,
        ImageService             $imageService,
        ImageRepositoryInterface $imageRepository,
        PostService              $postService,
        PostRepositoryInterface  $postRepository)
    {
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->imageService = $imageService;
        $this->imageRepository = $imageRepository;
        $this->authService = $authService;
        $this->renderer = $renderer;
    }

    #[Route('/', 'GET', [Role::user, Role::admin])]
    public function MainPage(MainPageRequest $request): ResponseInterface
    {
        if ($this->authService->isLoggedIn()) {
            $navbarView = new NavbarView();
            $postView = new PostView($this->postService->getPostsWithCommentRow());
            $mainPageView = new MainPageView($postView, $navbarView);
            return new HtmlResponse($mainPageView->renderWithRenderer($this->renderer));
        } else {
            return new RedirectResponse('/login', []);
        }

    }

    #[Route('/postData', 'POST', [Role::user, Role::admin])]
    public function handlePost(PostRequest $request): ResponseInterface
    {
        try {
            if (!empty($request->getImage())) {
                $currentData = new \DateTime();
                $imageName = $currentData->format('Ymdhi') . "."
                    . str_replace('image/', '', $request->getImageType());
                $this->postService->createPost(
                    $request->getPostTitle(),
                    $request->getPostContent(),
                    $request->getPostLink(),
                    $image = $this->imageService->createImage(
                        $imageName,
                        $request->getImageTmpName(),
                        $request->getImageType(),
                        $request->getImageSize()
                    )
                );
                $this->imageService->uploadPostImage($image);
            } else {
                $this->postService->createPost(
                    $request->getPostTitle(),
                    $request->getPostContent(),
                    $request->getPostLink()
                );
            }
        } catch (FileIsntImageException) {
            return new JsonResponse(['success' => false]);
        } catch (NotProperSizeException) {
            return new JsonResponse(['success' => false]);
        }
        return new JsonResponse(['success' => true]);
    }


}