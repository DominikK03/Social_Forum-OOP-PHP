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
use app\Repository\ImageRepository;
use app\Repository\PostRepository;
use app\Request\MainPageRequest;
use app\Request\PostRequest;
use app\Service\AuthService;
use app\Service\ImageService;
use app\Service\PostService;
use app\Util\TemplateRenderer;
use app\View\LoggedMainPageView;
use app\View\MainPageView;
use app\View\PostView;

#[AllowDynamicProperties] class MainPageController
{
    public function __construct(
        TemplateRenderer $renderer,
        AuthService      $authService,
        ImageService     $imageService,
        ImageRepository  $imageRepository,
        PostService      $postService,
        PostRepository   $postRepository)
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
            $postView = new PostView($this->postRepository->getPosts());
            $loggedMainPageView = new LoggedMainPageView($postView);
            return new HtmlResponse($loggedMainPageView->renderWithRenderer($this->renderer));
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
                    .str_replace('image/','', $request->getImageType());
                $this->imageRepository->uploadImage(
                    $image = $this->imageService->setImageData(
                        $imageName,
                        $request->getImageTmpName(),
                        $request->getImageType(),
                        $request->getImageSize())
                );
                $this->postRepository->insertPost(
                    $this->postService->setPostData(
                        $request->getPostTitle(),
                        $request->getPostContent(),
                        $request->getPostLink(),
                        $image)
                );
            } else {
                $this->postRepository->insertPost(
                    $this->postService->setPostData(
                        $request->getPostTitle(),
                        $request->getPostContent(),
                        $request->getPostLink())
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