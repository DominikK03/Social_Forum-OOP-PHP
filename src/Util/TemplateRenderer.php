<?php

namespace app\Util;


class TemplateRenderer
{
    public function renderHtml(string $html, array $data = []): string
    {
        $template = file_get_contents(TEMPLATE_PATH . '/' . $html);
        if ($data) {
            foreach ($data as $key => $value) {
                $template = str_replace($key, $value, $template);
            }
        }


        return $template;
    }

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

            $deleteIcon = '<span class="delete-post d-none" data-post-id="' . $post['post_id'] . '">
                           <img src="delete-icon.svg" alt="Delete Post" class="delete-post-icon">
                       </span>';

            $postsHtml .= '
        <div class="post-container mb-4 p-3 border rounded position-relative">
            ' . $deleteIcon . '
            <div class="post-header d-flex align-items-center">
                <img src="avatars/' . $post['avatar'] . '" class="border border-2 avatar-post me-2" alt="avatar">
                <h5 class="m-0">
                    ' . $post["user_name"] . '
                    <span class="text-muted">@' . $post["user_name"] . ' · ' . $postTimestamp->format('Y-m-d H:i') . '</span>
                </h5>
            </div>
            <div class="post-body mt-2">
                <p class="post-title fw-bold">' . $post['title'] . '</p>
                <p class="post-content">' . $post['content'] . '</p>
                <p class="post-link"><a href="' . $post['link'] . '">' . $post['link'] . '</a></p>
                ' . $postImage . '
                <div class="comment-section mt-3 d-flex align-items-center">
                    <a href="/post?postID=' . $post['post_id'] . '" class="text-decoration-none text-dark">
                        <img src="comment.svg" alt="comment" class="comment-icon me-2">
                        <span class="comment-count">' . $post['comment_count'] . '</span>
                    </a>
                </div>
            </div>
        </div>';
        }

        return str_replace('{{Post}}', $postsHtml, $template);
    }


    public function renderPost(string $html, array $post): string
    {
        $template = file_get_contents(TEMPLATE_PATH . '/' . $html);
        $postHtml = '';


        $postImage = '';
        if (!empty($post['image'])) {
            $postImage = '<img src="' . $post['image'] . '" class="post-image" alt="Post Image">';
        }
        $deleteIcon = '<span class="delete-post d-none" data-post-id="' . $post['post_id'] . '">
                           <img src="delete-icon.svg" alt="Delete Post" class="delete-post-icon">
                       </span>';
        $postTimestamp = new \DateTime($post['created_at']);
        $postHtml .= '
        <div class="post-container mb-4 p-3 border rounded">
            <div class="post-header d-flex align-items-center">
                     ' . $deleteIcon . '
                <img src="avatars/' . $post['avatar'] . '" class="border border-2 avatar-post me-2" alt="avatar">
                <h5 class="m-0">
                    ' . $post["user_name"] . '
                    <span class="text-muted">@' . $post["user_name"] . ' · ' . $postTimestamp->format('Y-m-d H:i') . '</span>
                </h5>
            </div>
            <div class="post-body mt-2">
                <p class="post-title fw-bold">' . $post['title'] . '</p>
                <p class="post-content">' . $post['content'] . '</p>
                <p class="post-link"><a href="' . $post['link'] . '">' . $post['link'] . '</a></p>
                ' . $postImage . '
            </div>
        </div>';

        return str_replace('{{Post}}', $postHtml, $template);
    }
    public function renderComments(string $html, array $data)
    {
        $template = file_get_contents(TEMPLATE_PATH . '/' . $html);
        $commentsHtml = '';


        foreach ($data as $comment) {
            $deleteIcon = '<span class="delete-comment d-none" data-comment-id="' . $comment['comment_id'] . '">
                           <img src="delete-icon.svg" alt="Delete Comment" class="delete-comment-icon">
                       </span>';
            $commentTimestamp = new \DateTime($comment['created_at']);
            $commentsHtml .= '
            <div class="comment-container">
                        <div class="comment-header">
                        ' . $deleteIcon . '
                            <h5>  <img src="avatars/' . $comment['avatar'] . '" class = "border border-2 avatar-post" alt="avatar"> ' . $comment["user_name"] . ' 
                                <span class="text-muted">@' . $comment["user_name"] . ' · ' . $commentTimestamp->format('Y-m-d H:i') . '</span>
                            </h5>
                        </div>
                        <div class="comment-body">
                            <p class="comment-content">' . $comment['content'] . '</p>
                      </div>
            </div>';
        }
        return str_replace('{{Comment}}', $commentsHtml, $template);
    }
}

