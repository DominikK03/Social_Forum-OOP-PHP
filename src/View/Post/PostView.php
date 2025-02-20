<?php

namespace app\View\Post;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\ViewInterface;

#[AllowDynamicProperties]
class PostView implements ViewInterface
{
    const POST_VIEW_TEMPLATE = 'post/post.html';
    const POST_HEADER_TEMPLATE = 'post/postheader.html';
    const POST_BODY_TEMPLATE = 'post/postbody.html';
    const POST_FOOTER_TEMPLATE = 'post/postfooter.html';
    public function __construct(array $posts)
    {
        $this->posts = $posts;
    }
    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        $postsHtml = '';
        foreach ($this->posts as $post) {
            $postHeader = $renderer->renderHtml(self::POST_HEADER_TEMPLATE, [
                'postID' => $post['postID'],
                'userName' => $post['userName'],
                'createdAt' => (new \DateTime($post['createdAt']))->format('Y-m-d H:i'),
                'avatar' => $post['avatar'],
            ]);
            $postBody = $renderer->renderHtml(self::POST_BODY_TEMPLATE, [
                'title' => $post['title'],
                'content' => $post['content'],
                'link' => $post['link'],
                'postImage' => !empty($post['image']) ? '<img src="' . $post['image'] . '" class="post-image" alt="Post Image">' : '',
            ]);
            $postFooter = $renderer->renderHtml(self::POST_FOOTER_TEMPLATE, [
                'postID' => $post['postID'],
                'commentCount' => $post['comment_count'],
            ]);
            $postsHtml .= $renderer->renderHtml(self::POST_VIEW_TEMPLATE, [
                'PostHeader' => $postHeader,
                'PostBody' => $postBody,
                'PostFooter' => $postFooter,
            ]);
        }
        return $postsHtml;
    }
}
