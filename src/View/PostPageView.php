<?php

namespace app\View;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;

#[AllowDynamicProperties] class PostPageView implements ViewInterface
{
    public function __construct(TeewtView $teewtView)
    {
        $this->teewtView = $teewtView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('postpage.html', [
            'Teewt' => $this->teewtView->renderWithRenderer($renderer)
        ]);
    }

}