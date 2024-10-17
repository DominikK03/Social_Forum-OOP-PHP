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

    public function fromPostRequest()
    {
        $this->commentContent = htmlspecialchars($this->request->getRequestParam('commentInput'));
    }

    public function fromGetRequest()
    {
        $this->postID = $this->request->getQueryParams('postID');
        $this->username = $this->request->getSessionParam('user','username');
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