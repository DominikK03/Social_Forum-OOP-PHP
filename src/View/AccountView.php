<?php

namespace app\View;

use app\Util\TemplateRenderer;

class AccountView implements ViewInterface
{

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('accountpage.html');
    }
}