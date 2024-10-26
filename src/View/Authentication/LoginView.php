<?php

namespace app\View\Authentication;

use app\Util\TemplateRenderer;
use app\View\ViewInterface;

class LoginView implements ViewInterface
{

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('auth/loginpage.html');
    }
}