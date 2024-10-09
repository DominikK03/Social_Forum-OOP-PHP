<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\JsonResponse;
use app\Core\HTTP\Response\ResponseInterface;
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
    public function __construct(TemplateRenderer $renderer,
                                AuthService $authService,
                                ImageService    $imageService,
                                ImageRepository $imageRepository,
                                PostService     $postService,
                                PostRepository  $postRepository)
    {
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->imageService = $imageService;
        $this->imageRepository = $imageRepository;
        $this->authService = $authService;
        $this->renderer = $renderer;
        $this->postView = new PostView([]);
        $this->mainpageView = new MainPageView($this->postView);
        $this->loggedMainPageView = new LoggedMainPageView($this->postView);


    }

    #[Route('/', 'GET')]
    public function MainPage(MainPageRequest $request) :  ResponseInterface
    {
        if ($this->authService->isLoggedIn()){
            return new HtmlResponse($this->loggedMainPageView->renderWithRenderer($this->renderer));
        }else{
            return new HtmlResponse($this->mainpageView->renderWithRenderer($this->renderer));
        }

    }

    #[Route('/postData', 'POST')]
    public function handlePost(PostRequest $request): ResponseInterface
    {
        try {
            if (isset($_FILES['image'])) {
                $this->imageRepository->uploadImage(
                    $image = $this->imageService->setImageData(
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
        return new JsonResponse(['success'=>true]);
    }



}