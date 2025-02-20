<?php

namespace app\View\Authentication;


use app\Util\TemplateRenderer;
use app\View\ViewInterface;

class RegisterView implements ViewInterface
{
    const REGISTER_VIEW = 'auth/registerpage.html';
    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml(self::REGISTER_VIEW);
    }
}