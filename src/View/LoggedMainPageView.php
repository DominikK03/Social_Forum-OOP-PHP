<?php

namespace app\View;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;

#[AllowDynamicProperties] class LoggedMainPageView implements ViewInterface
{
    public function __construct(PostView $postView)
    {
        $this->postView = $postView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('loggedmainpage.html', [
            '{{Post}}' => $this->postView->renderWithRenderer($renderer)
        ]);
    }
}