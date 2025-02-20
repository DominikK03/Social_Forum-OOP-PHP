<?php

namespace app\View\Post;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\Util\NavbarView;
use app\View\ViewInterface;

#[AllowDynamicProperties] class PostPageView implements ViewInterface
{
    const POST_PAGE_VIEW = 'postpage/postpage.html';
    public function __construct(TeewtView $teewtView, NavbarView $navbarView)
    {
        $this->teewtView = $teewtView;
        $this->navbarView = $navbarView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml(self::POST_PAGE_VIEW, [
            'Navbar' =>$this->navbarView->renderWithRenderer($renderer),
            'Teewt' => $this->teewtView->renderWithRenderer($renderer)
        ]);
    }

}