<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\JsonResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Enum\Role;
use app\Exception\EmptyCommentException;
use app\Repository\Comment\CommentRepositoryInterface;
use app\Repository\Post\PostRepository;
use app\Request\CommentRequest;
use app\Service\Comment\CommentService;
use app\Service\Post\PostService;
use app\Util\TemplateRenderer;
use app\View\Post\CommentView;
use app\View\Post\PostPageView;
use app\View\Post\SinglePostView;
use app\View\Post\TeewtView;
use app\View\Util\NavbarView;

#[AllowDynamicProperties] class PostPageController
{
    public function __construct(
        TemplateRenderer $renderer,
        PostService $postService,
        CommentService $commentService,
    )
    {
        $this->renderer = $renderer;
        $this->postService = $postService;
        $this->commentService = $commentService;
    }


    #[Route('/post', 'GET', [Role::user, Role::admin, Role::master])]
    public function postPageView(CommentRequest $request): ResponseInterface
    {
        $navbarView = new NavbarView();
        $postView = new SinglePostView($this->postService->postRepository->getPost($request->getPostID()));
        $commentView = new CommentView($this->commentService->commentRepository->getComments($request->getPostID()));
        $teewtView = new TeewtView($postView, $commentView);
        $postPageView = new PostPageView($teewtView, $navbarView);
        return new HtmlResponse($postPageView->renderWithRenderer($this->renderer));
    }

    #[Route('/post/postComment', 'POST', [Role::user, Role::admin, Role::master])]
    public function handleComment(CommentRequest $request) : ResponseInterface
    {
        try {
            $this->commentService->createComment(
                $request->getCommentContent(),
                $request->getUsername(),
                $request->getPostID()
            );
        }catch (EmptyCommentException $e){
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }catch (\Exception $exception){
            return new JsonResponse(['success'=>false, 'message'=>$exception->getMessage()]);
        }
        return new JsonResponse(['success' => true]);
    }
    #[Route('/post/deleteComment', 'POST', [Role::admin, Role::master])]
    public function handleCommentDelete(CommentRequest $request) : ResponseInterface
    {
        $this->commentService->commentRepository->deleteCommentByID($request->getCommentID());
        return new JsonResponse(['success'=>true]);
    }

}