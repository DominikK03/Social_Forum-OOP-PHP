<?php

namespace app\View\MainPage;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\Post\PostView;
use app\View\Util\NavbarView;
use app\View\Util\PostFormView;
use app\View\ViewInterface;

#[AllowDynamicProperties] class MainPageView implements ViewInterface
{
    public function __construct(PostView $postView, NavbarView $navbarView, PostFormView $formView)
    {
        $this->formView = $formView;
        $this->navbarView = $navbarView;
        $this->postView = $postView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('mainpage/mainpage.html',[
            '{{Post}}' => $this->postView->renderWithRenderer($renderer),
            '{{PostForm}}' => $this->formView->renderWithRenderer($renderer),
            '{{Navbar}}' => $this->navbarView->renderWithRenderer($renderer)
        ]);
    }
}