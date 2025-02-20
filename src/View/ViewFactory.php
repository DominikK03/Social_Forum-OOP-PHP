<?php

namespace app\View;
use app\Util\TemplateRenderer;
use app\View\Account\AccountInfoView;
use app\View\Account\AccountView;
use app\View\Admin\AdminPanelView;
use app\View\Authentication\LoginView;
use app\View\Authentication\RegisterView;
use app\View\error\AccessDeniedView;
use app\View\error\PageNotFoundView;
use app\View\MainPage\MainPageView;
use app\View\Post\CommentView;
use app\View\Post\PostPageView;
use app\View\Post\PostView;
use app\View\Post\SinglePostView;
use app\View\Post\TeewtView;
use app\View\Util\NavbarView;
use app\View\Util\PostFormView;

class ViewFactory
{
    public static function createNavBarView() : NavbarView
    {
        return new NavbarView();
    }

    public function createAccountView(AccountInfoView $accountInfoView): AccountView
    {
        return new AccountView($accountInfoView, $this->createNavBarView());
    }

    public function createAccountInfoView(array $data): AccountInfoView
    {
        return new AccountInfoView($data);
    }
    public function createAdminPanelView(): AdminPanelView
    {
        return new AdminPanelView($this->createNavBarView());
    }
    public static function createRegistrationView(): RegisterView
    {
        return new RegisterView();
    }
    public static function createLoginView(): LoginView
    {
        return new LoginView();
    }
    public static function createPostFormView(): PostFormView
    {
        return new PostFormView();
    }
    public function createPostView(array $data): PostView
    {
        return new PostView($data);
    }
    public function createMainPageView(PostView $postView): MainPageView
    {
        return new MainPageView($postView, $this->createNavBarView(), $this->createPostFormView());
    }
    public function createSinglePostView(array $data): SinglePostView
    {
        return new SinglePostView($data);
    }
    public function createCommentView(array $data): CommentView
    {
        return new CommentView($data);
    }
    public function createTeewtView(SinglePostView $singlePostView, CommentView $commentView): TeewtView
    {
        return new TeewtView($singlePostView, $commentView);
    }
    public function createPostPageView(TeewtView $teewtView): PostPageView
    {
        return new PostPageView($teewtView, $this->createNavBarView());
    }
    public static function create404ResponseView(): PageNotFoundView
    {
        return new PageNotFoundView();
    }
    public static function create401ResponseView(): AccessDeniedView
    {
        return new AccessDeniedView();
    }

}