<?php

namespace app\View\Account;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\NavbarView;
use app\View\ViewInterface;

#[AllowDynamicProperties] class AccountView implements ViewInterface
{
    public function __construct(AccountInfoView $accountInfoView, NavbarView $navbarView)
    {
        $this->accountInfoView = $accountInfoView;
        $this->navbarView = $navbarView;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('accountpage.html', [
            '{{AccountInfo}}' => $this->accountInfoView->renderWithRenderer($renderer),
            '{{Navbar}}' => $this->navbarView->renderWithRenderer($renderer)
        ]);
    }
}