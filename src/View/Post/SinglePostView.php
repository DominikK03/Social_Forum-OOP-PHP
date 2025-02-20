<?php

namespace app\View\Post;

use AllowDynamicProperties;
use app\Exception\FileNotFoundException;
use app\Util\TemplateRenderer;
use app\View\ViewInterface;

#[AllowDynamicProperties]
class SinglePostView implements ViewInterface
{
    const SINGLE_POST_VIEW_TEMPLATE = 'postpage/singlepost.html';

    private array $post;

    public function __construct(array $post)
    {
        $this->post = $post;
    }

    /**
     * @throws \DateMalformedStringException
     * @throws FileNotFoundException
     */
    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        $postHeader = $renderer->renderHtml(PostView::POST_HEADER_TEMPLATE, [
            'postID' => $this->post['postID'],
            'userName' => $this->post['userName'],
            'createdAt' => (new \DateTime($this->post['createdAt']))->format('Y-m-d H:i'),
            'avatar' => $this->post['avatar'],
        ]);

        $postBody = $renderer->renderHtml(PostView::POST_BODY_TEMPLATE, [
            'title' => $this->post['title'],
            'content' => $this->post['content'],
            'link' => $this->post['link'],
            'postImage' => !empty($this->post['image']) ? '<img src="' . $this->post['image'] . '" class="post-image" alt="Post Image">' : '',
        ]);

        return $renderer->renderHtml(self::SINGLE_POST_VIEW_TEMPLATE, [
            'PostHeader' => $postHeader,
            'PostBody' => $postBody,
        ]);
    }
}
