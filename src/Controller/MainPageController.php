<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\ErrorResponses\NotLoggedInRedirectResponse;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Core\HTTP\Response\SuccessfullResponse;
use app\Core\HTTP\Response\UnsuccessfullResponse;
use app\Enum\Role;
use app\Exception\FileIsntImageException;
use app\Exception\NotProperSizeException;
use app\Request\MainPageRequest;
use app\Request\PostRequest;
use app\Service\AdminService\AdminService;
use app\Service\Auth\AuthService;
use app\Service\Image\ImageService;
use app\Service\Post\PostService;
use app\Util\TemplateRenderer;
use app\View\Admin\AdminMainPageView;
use app\View\Admin\AdminPostView;
use app\View\ViewFactory;

#[AllowDynamicProperties]
class MainPageController
{
    public function __construct(
        TemplateRenderer $renderer,
        AuthService $authService,
        ImageService $imageService,
        PostService $postService,
        AdminService $adminService,
        ViewFactory $viewFactory
    )
    {
        $this->postService = $postService;
        $this->imageService = $imageService;
        $this->authService = $authService;
        $this->renderer = $renderer;
        $this->adminService = $adminService;
        $this->viewFactory = $viewFactory;
    }
    #[Route("/", 'GET', [Role::user])]
    public function MainPage(MainPageRequest $request): ResponseInterface
    {
        if ($this->authService->isLoggedIn()) {
            return new HtmlResponse(
                $this->viewFactory->createMainPageView(
                    $this->viewFactory->createPostView(
                        $this->postService->getPostsWithCommentRow()
                    )
                )->renderWithRenderer($this->renderer)
            );
        } else {
            return new NotLoggedInRedirectResponse();
        }
    }
    #[Route('/postData', 'POST', [Role::user])]
    public function handlePost(PostRequest $request): ResponseInterface
    {
        try {
            if (!empty($request->getImage())) {
                $this->postService->createPost(
                    $this->authService->getLoggedInUser($request->getUserSession()),
                    $request->getPostTitle(),
                    $request->getPostContent(),
                    $request->getPostLink(),
                    $image = $this->imageService->createPostImage(
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
            return new SuccessfullResponse();
        } catch (FileIsntImageException) {
            return new UnsuccessfullResponse();
        } catch (NotProperSizeException) {
            return new UnsuccessfullResponse();
        }
    }
    #[Route('/deletePost', 'POST', [Role::admin])]
    public function handlePostDelete(PostRequest $request): ResponseInterface
    {
        $this->adminService->deletePostByID($request->getDeletePostID());
        return new SuccessfullResponse();
    }
}