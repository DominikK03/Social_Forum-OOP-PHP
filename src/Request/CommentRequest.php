<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;

#[AllowDynamicProperties] class CommentRequest extends Request implements RequestInterface
{

    private string $postID;
    private string $commentContent;
    private string $username;


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function fromRequest()
    {
        $this->postID = $this->request->getQueryParams('postID');
        $this->username = $this->request->getSessionParam('user', 'username');
        if (!empty($this->request->getRequest())) {
            $this->commentContent = htmlspecialchars($this->request->getRequestParam('comment'));
        }
    }

    /**
     * @return string
     */
    public function getPostID(): string
    {
        return $this->postID;
    }

    /**
     * @return string
     */
    public function getCommentContent(): string
    {
        return $this->commentContent;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}