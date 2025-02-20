<?php

namespace app\View\Post;

use AllowDynamicProperties;
use app\Exception\FileNotFoundException;
use app\Util\TemplateRenderer;
use app\View\ViewInterface;

#[AllowDynamicProperties] class TeewtView implements ViewInterface
{
    const TEEWT_VIEW = 'postpage/teewt.html';
    public function __construct(SinglePostView $postView, CommentView $commentView)
    {
        $this->singlePostView = $postView;
        $this->commentView = $commentView;
    }
    /**
     * @throws \DateMalformedStringException
     * @throws FileNotFoundException
     */
    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml(self::TEEWT_VIEW, [
            'PostView' => $this->singlePostView->renderWithRenderer($renderer),
            'CommentView' => $this->commentView->renderWithRenderer($renderer)
        ]);
    }
}