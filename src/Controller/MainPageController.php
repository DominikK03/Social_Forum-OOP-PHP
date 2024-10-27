<?php

namespace app\Controller;
require '../vendor/autoload.php';


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
use app\View\Admin\AdminMainPageView;
use app\View\Admin\AdminPostView;
use app\View\MainPage\MainPageView;
use app\View\Post\PostView;
use app\View\Util\NavbarView;
use app\View\Util\PostFormView;

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

    #[Route("/", 'GET', [Role::user, Role::admin, Role::master])]
    public function MainPage(MainPageRequest $request): ResponseInterface
    {
        if ($this->authService->isLoggedIn()) {
            $postFormView = new PostFormView();
            $navbarView = new NavbarView();
            $postView = new PostView($this->postService->getPostsWithCommentRow());
            $mainPageView = new MainPageView($postView, $navbarView, $postFormView);
            return new HtmlResponse($mainPageView->renderWithRenderer($this->renderer));

        } else {
            return new RedirectResponse('/login', []);
        }

    }

    #[Route('/postData', 'POST', [Role::user, Role::admin, Role::master])]
    public function handlePost(PostRequest $request): ResponseInterface
    {
        try {
            if (!empty($request->getImage())) {
                $currentData = new \DateTime();
                $imageName = $currentData->format('Ymdhis') . "."
                    . str_replace('image/', '', $request->getImageType());
                $this->postService->createPost(
                    $this->authService->getLoggedInUser($request->getUserSession()),
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
                    $this->authService->getLoggedInUser($request->getUserSession()),
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
    #[Route('/deletePost', 'POST', [Role::admin, Role::master])]
    public function handlePostDelete(PostRequest $request) : ResponseInterface
    {
        $this->postService->deletePostByID($request->getDeletePostID());
        return new JsonResponse(['success'=>true]);
    }
}