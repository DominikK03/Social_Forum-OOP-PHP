<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Request\Request;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Request\LoginPageRequest;
use app\Util\TemplateRenderer;
use app\View\LoginView;

#[AllowDynamicProperties] class LoginController
{
    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
        $this->loginView = new LoginView();
    }

    #[Route('/login', 'GET')]
    public function loginView(LoginPageRequest $request) : ResponseInterface
    {
        return new HtmlResponse($this->loginView->renderWithRenderer($this->renderer));
    }

    public function handleLogin(LoginDataRequest $request) : ResponseInterface
    {

    }

}