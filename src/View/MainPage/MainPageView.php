<?php

namespace app\View\MainPage;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\NavbarView;
use app\View\Post\PostView;
use app\View\ViewInterface;

#[AllowDynamicProperties] class MainPageView implements ViewInterface
{
    public function __construct(PostView $postView, NavbarView $navbarView)
    {
        $this->navbarView = $navbarView;
        $this->postView = $postView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('mainpage.html',[
            '{{Post}}' => $this->postView->renderWithRenderer($renderer),
            '{{Navbar}}' => $this->navbarView->renderWithRenderer($renderer)
        ]);
    }
}