<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Core\HTTP\Response\SuccessfullResponse;
use app\Core\HTTP\Response\UnsuccessfullResponse;
use app\Enum\Role;
use app\Exception\EmptyCommentException;
use app\Request\CommentRequest;
use app\Service\AdminService\AdminService;
use app\Service\Comment\CommentService;
use app\Service\Post\PostService;
use app\Util\TemplateRenderer;
use app\View\ViewFactory;

#[AllowDynamicProperties]
class PostPageController
{
    public function __construct(
        TemplateRenderer $renderer,
        PostService $postService,
        CommentService $commentService,
        AdminService $adminService,
        ViewFactory $viewFactory
    )
    {
        $this->renderer = $renderer;
        $this->postService = $postService;
        $this->commentService = $commentService;
        $this->adminService = $adminService;
        $this->viewFactory = $viewFactory;
    }
    #[Route('/post', 'GET', [Role::user, Role::admin, Role::master])]
    public function postPageView(CommentRequest $request): ResponseInterface
    {
        $postPageView =
            $this->viewFactory->createPostPageView(
                $this->viewFactory->createTeewtView(
                    $this->viewFactory->createSinglePostView(
                        $this->postService->postRepository->getPost(
                            $request->getPostID()
                        )),
                    $this->viewFactory->createCommentView(
                        $this->commentService->commentRepository->getComments($request->getPostID()
                        ))
                )
            );
        return new HtmlResponse($postPageView->renderWithRenderer($this->renderer));
    }
    #[Route('/post/postComment', 'POST', [Role::user, Role::admin, Role::master])]
    public function handleComment(CommentRequest $request): ResponseInterface
    {
        try {
            $this->commentService->createComment(
                $request->getCommentContent(),
                $request->getUsername(),
                $request->getPostID()
            );
            return new SuccessfullResponse();
        } catch (EmptyCommentException $e) {
            return new UnsuccessfullResponse(['message' => $e->getMessage()]);
        }

    }
    #[Route('/post/deleteComment', 'POST', [Role::admin, Role::master])]
    public function handleCommentDelete(CommentRequest $request): ResponseInterface
    {
        $this->adminService->deleteCommentByID($request->getCommentID());
        return new SuccessfullResponse();
    }
}