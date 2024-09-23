<?php

namespace app\View;


use app\Util\TemplateRenderer;

class RegisterView implements ViewInterface
{

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('registerpage.html');
    }
}