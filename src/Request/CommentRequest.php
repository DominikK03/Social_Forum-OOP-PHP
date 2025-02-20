<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;
use app\Model\User;

#[AllowDynamicProperties]
class CommentRequest extends Request implements RequestInterface
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
        $this->username = $this->request->getSessionParam(User::USER, User::USERNAME);
        if ($this->request->getQuery()) {
            $this->postID = $this->request->getQueryParams('postID');
        }
        if (!empty($this->request->getRequestParam('comment'))) {
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
    public function getCommentID(): ?string
    {
        return $this->getRequestParam('comment_id');
    }

}
