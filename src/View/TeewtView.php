<?php

namespace app\View;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;

#[AllowDynamicProperties] class TeewtView implements ViewInterface
{

    public function __construct(PostView $postView, CommentView $commentView)
    {
        $this->postView = $postView;
        $this->commentView = $commentView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('teewt.html', [
            'PostView' => $this->postView->renderWithRenderer($renderer),
            'CommentView' => $this->commentView->renderWithRenderer($renderer)
        ]);
    }
}