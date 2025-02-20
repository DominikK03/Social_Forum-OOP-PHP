<?php

namespace app\View\error;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\ViewInterface;

#[AllowDynamicProperties] class PageNotFoundView implements ViewInterface
{
    const ERROR404_VIEW = 'error/404.html';
    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml(self::ERROR404_VIEW);
    }
}