<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\RedirectResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Model\Post;
use app\Request\LogoutRequest;
use app\Request\MainPageRequest;
use app\Service\AuthService;
use app\Util\TemplateRenderer;
use app\View\CommentView;
use app\View\MainPageView;
use app\View\PostView;
use app\View\TeewtView;

#[AllowDynamicProperties] class MainPageController
{
    public function __construct(TemplateRenderer $renderer, AuthService $authService)
    {
        $this->authService = $authService;
        $this->renderer = $renderer;
    }

    #[Route('/', 'GET')]
    public function MainPage(MainPageRequest $request) :  ResponseInterface
    {
        var_dump($_SESSION);

    }



}