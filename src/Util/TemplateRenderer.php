<?php

namespace app\Util;


class TemplateRenderer
{
    public function renderHtml(string $html, array $data = []): string
    {
        $template = file_get_contents(TEMPLATE_PATH . '/' . $html);

        foreach ($data as $key => $value) {
            $template = str_replace($key, $value, $template);
        }

        return $template;
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function renderPosts(string $html, array $data): string
    {
        $template = file_get_contents(TEMPLATE_PATH . '/' . $html);
        $postsHtml = '';

        foreach ($data as $post) {
            $postImage = '';
            if (!empty($post['image'])) {
                $postImage .= '<img src="' . $post['image'] . '" class="post-image" alt="Post Image">';
            }
            $postTimestamp = new \DateTime($post['created_at']);
            $postsHtml .= '<div class="post-container">
                        <div class="post-header">
                            <h5>  <img src="avatars/' . $post['avatar'] . '" class = "border border-2 avatar-post" alt="avatar"> ' . $post["user_name"] . ' 
                                <span class="text-muted">@' . $post["user_name"] . ' · ' . $postTimestamp->format('Y-m-d H:i') . '</span>
                            </h5>
                        </div>
                        <div class="post-body">
                            <p class="post-title"><strong>' . $post['title'] . '</strong></p>
                            <p class="post-content">' . $post['content'] . '</p>
                            <p class="post-link">' . $post['link'] . '</p>'
                . $postImage .
                ' <a href="/post?postID='.$post['post_id'].'"><img src="comment.svg" alt="comment"> </a>
                            </div>
            </div>';
        }


        return str_replace('{{Post}}', $postsHtml, $template);
    }

    public function renderPost(string $html, array $data): string
    {
        $template = file_get_contents(TEMPLATE_PATH . '/' . $html);
        $postsHtml = '';

        foreach ($data as $post) {
            $postImage = '';
            if (!empty($post['image'])) {
                $postImage = '<img src="' . $post['image'] . '" class="post-image" alt="Post Image">';
            }
            $postTimestamp = new \DateTime($post['created_at']);
            $postsHtml = '<div class="post-container">
                        <div class="post-header">
                            <h5>  <img src="avatars/' . $post['avatar'] . '" class = "border border-2 avatar-post" alt="avatar"> ' . $post["user_name"] . ' 
                                <span class="text-muted">@' . $post["user_name"] . ' · ' . $postTimestamp->format('Y-m-d H:i') . '</span>
                            </h5>
                        </div>
                        <div class="post-body">
                            <p class="post-title"><strong>' . $post['title'] . '</strong></p>
                            <p class="post-content">' . $post['content'] . '</p>
                            <p class="post-link">' . $post['link'] . '</p>'
                . $postImage .
            '</div>
            </div>';
        }


        return str_replace('{{Post}}', $postsHtml, $template);
    }

}

