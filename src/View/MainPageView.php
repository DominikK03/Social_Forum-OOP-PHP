<?php

namespace app\View;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;

#[AllowDynamicProperties] class MainPageView implements ViewInterface
{
    public function __construct(PostView $postView)
    {
        $this->postView = $postView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('mainpage.html', [
            '{{Post}}' => $this->postView->renderWithRenderer($renderer)
        ]);
    }
}