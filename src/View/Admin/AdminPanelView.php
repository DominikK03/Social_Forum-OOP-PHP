<?php

namespace app\View\Admin;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\Util\NavbarView;
use app\View\ViewInterface;

#[AllowDynamicProperties] class AdminPanelView implements ViewInterface
{
    const ADMIN_PANEL_VIEW = 'admin/adminpanel.html';
    public function __construct(NavbarView $navbarView)
    {
        $this->navbarView = $navbarView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml(self::ADMIN_PANEL_VIEW, [
            'Navbar' => $this->navbarView->renderWithRenderer($renderer)
        ]);
    }
}