<?php

namespace app\View\Authentication;

use app\Util\TemplateRenderer;
use app\View\ViewInterface;

class LoginView implements ViewInterface
{
    const LOGIN_PAGE_VIEW = 'auth/loginpage.html';
    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml(self::LOGIN_PAGE_VIEW);
    }
}