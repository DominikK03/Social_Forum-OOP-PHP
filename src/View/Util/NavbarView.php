<?php

namespace app\View\Util;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\ViewInterface;

#[AllowDynamicProperties] class NavbarView implements ViewInterface
{
    const NAVBAR_VIEW = 'utils/navbar.html';
    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml(self::NAVBAR_VIEW);
    }
}