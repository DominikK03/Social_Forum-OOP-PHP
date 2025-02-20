<?php

namespace app\View\Post;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\ViewInterface;

#[AllowDynamicProperties]
class CommentView implements ViewInterface
{
    private const COMMENT_VIEW_TEMPLATE = 'comment/comment.html';
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        $commentsHtml = '';

        foreach ($this->data as $comment) {
            $commentData = [
                'userName' => $comment['userName'],
                'createdAt' => (new \DateTime($comment['createdAt']))->format('Y-m-d H:i'),
                'avatar' => $comment['avatar'],
                'content' => $comment['content'],
                'deleteIcon' => '<span class="delete-comment d-none" data-comment-id="' . $comment['commentID'] . '">
                                    <img src="delete-icon.svg" alt="Delete Comment" class="delete-comment-icon">
                                 </span>',
            ];

            $commentsHtml .= $renderer->renderHtml(self::COMMENT_VIEW_TEMPLATE, $commentData);
        }

        return $commentsHtml;
    }
}
