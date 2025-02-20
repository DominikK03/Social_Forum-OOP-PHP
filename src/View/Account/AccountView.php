<?php

namespace app\View\Account;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\Admin\AdminNavbarView;
use app\View\Util\NavbarView;
use app\View\ViewInterface;

#[AllowDynamicProperties] class AccountView implements ViewInterface
{
    const ACCOUNT_VIEW = 'account/accountpage.html';
    public function __construct(
        AccountInfoView $accountInfoView,
        NavbarView      $navbarView,
    )
    {
        $this->accountInfoView = $accountInfoView;
        $this->navbarView = $navbarView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml(self::ACCOUNT_VIEW, [
            'AccountInfo' => $this->accountInfoView->renderWithRenderer($renderer),
            'Navbar' => $this->navbarView->renderWithRenderer($renderer)
        ]);
    }
}