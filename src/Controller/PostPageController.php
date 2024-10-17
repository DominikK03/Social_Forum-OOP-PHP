<?php

namespace app\Controller;

use AllowDynamicProperties;
use app\Core\HTTP\Attribute\Route;
use app\Core\HTTP\Response\HtmlResponse;
use app\Core\HTTP\Response\JsonResponse;
use app\Core\HTTP\Response\ResponseInterface;
use app\Enum\Role;
use app\Exception\EmptyCommentException;
use app\Repository\CommentRepositoryInterface;
use app\Repository\PostRepository;
use app\Request\CommentRequest;
use app\Service\CommentService;
use app\Util\TemplateRenderer;
use app\View\CommentView;
use app\View\PostPageView;
use app\View\SinglePostView;
use app\View\TeewtView;

#[AllowDynamicProperties] class PostPageController
{
    public function __construct(
        TemplateRenderer $renderer,
        PostRepository $postRepository,
        CommentRepositoryInterface $commentRepository,
        CommentService $commentService)
    {
        $this->renderer = $renderer;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->commentService = $commentService;
    }


    #[Route('/post', 'GET', [Role::user, Role::admin])]
    public function postPageView(CommentRequest $request): ResponseInterface
    {
        $postView = new SinglePostView($this->postRepository->getPost($request->getPostID()));
        $commentView = new CommentView([]);
        $teewtView = new TeewtView($postView, $commentView);
        $postPageView = new PostPageView($teewtView);
        return new HtmlResponse($postPageView->renderWithRenderer($this->renderer));
    }

    #[Route('/postcomment', 'POST', [Role::user, Role::admin])]
    public function handleComment(CommentRequest $request) : ResponseInterface
    {
        try {
            $this->commentRepository
                ->insertComment(
                    $this->commentService
                        ->setCommentData(
                            $request->getCommentContent(),
                            $request->getUsername(),
                            $request->getPostID()
                        ));
        }catch (EmptyCommentException $e){
            return new JsonResponse(['success' => false, 'message' => $e->getMessage()]);
        }catch (\Exception $exception){
            return new JsonResponse(['success'=>false, 'message'=>$exception->getMessage()]);
        }
        return new JsonResponse(['success' => true]);
    }

}