<?php

namespace app\View\Post;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\Util\NavbarView;
use app\View\ViewInterface;

#[AllowDynamicProperties] class PostPageView implements ViewInterface
{
    public function __construct(TeewtView $teewtView, NavbarView $navbarView)
    {
        $this->teewtView = $teewtView;
        $this->navbarView = $navbarView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('post/postpage.html', [
            '{{Navbar}}' =>$this->navbarView->renderWithRenderer($renderer),
            '{{Teewt}}' => $this->teewtView->renderWithRenderer($renderer)
        ]);
    }

}