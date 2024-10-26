<?php

namespace app\View\Authentication;


use app\Util\TemplateRenderer;
use app\View\ViewInterface;

class RegisterView implements ViewInterface
{

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('auth/registerpage.html');
    }
}