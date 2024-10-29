<?php

namespace app\View\Post;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\ViewInterface;

#[AllowDynamicProperties] class TeewtView implements ViewInterface
{

    public function __construct(SinglePostView $postView, CommentView $commentView)
    {
        $this->singlePostView = $postView;
        $this->commentView = $commentView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('post/teewt.html', [
            '{{PostView}}' => $this->singlePostView->renderWithRenderer($renderer),
            '{{CommentView}}' => $this->commentView->renderWithRenderer($renderer)
        ]);
    }
}