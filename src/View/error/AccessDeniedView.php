<?php

namespace app\View\error;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\ViewInterface;

#[AllowDynamicProperties] class AccessDeniedView implements ViewInterface
{
    const ERROR401_VIEW = 'error/401.html';
    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml(self::ERROR401_VIEW);
    }
}