<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Request\PostRequest;
use app\Util\TemplateRenderer;
use app\View\CommentView;
use app\View\LoggedMainPageView;
use app\View\MainPageView;
use app\View\PostPageView;
use app\View\PostView;
use app\View\TeewtView;

#[AllowDynamicProperties] class PostPageController
{
    public function __construct(TemplateRenderer $renderer)
    {
        $this->renderer = $renderer;
    }


    public function postPageView(PostRequest $request): ResponseInterface
    {
        $this->postView = new PostView([]);
        $this->commentView = new CommentView([]);
        $this->teewtView = new TeewtView($this->postView, $this->commentView);
        $this->postPageView = new PostPageView($this->teewtView);
        return new HtmlResponse($this->postPageView->renderWithRenderer($this->renderer));

    }

}