<?php

namespace app\View\Admin;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\Util\NavbarView;
use app\View\ViewInterface;

#[AllowDynamicProperties] class AdminPanelView implements ViewInterface
{
    public function __construct(NavbarView $navbarView)
    {
        $this->navbarView = $navbarView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('admin/adminpanel.html', [
            '{{Navbar}}' => $this->navbarView->renderWithRenderer($renderer)
        ]);
    }
}