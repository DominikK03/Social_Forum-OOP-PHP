<?php

namespace app\View\Util;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\ViewInterface;

#[AllowDynamicProperties] class PostFormView implements ViewInterface
{
    const POST_FORM_VIEW = 'utils/postform.html';
    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml(self::POST_FORM_VIEW);
    }

}