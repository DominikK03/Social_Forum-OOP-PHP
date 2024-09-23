<?php

namespace app\View;

use app\Util\TemplateRenderer;

class LoginView implements ViewInterface
{

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('loginpage.html');
    }
}