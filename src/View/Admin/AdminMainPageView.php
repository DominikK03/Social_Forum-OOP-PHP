<?php

namespace app\View\Admin;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\Util\PostFormView;
use app\View\ViewInterface;

#[AllowDynamicProperties] class AdminMainPageView implements ViewInterface
{
    public function __construct(AdminPostView $postView, AdminNavbarView $navbarView, PostFormView $formView)
    {
        $this->formView = $formView;
        $this->navbarView = $navbarView;
        $this->postView = $postView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('admin/adminmainpage.html',[
            '{{Post}}' => $this->postView->renderWithRenderer($renderer),
            '{{PostForm}}' => $this->formView->renderWithRenderer($renderer),
            '{{Navbar}}' => $this->navbarView->renderWithRenderer($renderer)
        ]);
    }
}