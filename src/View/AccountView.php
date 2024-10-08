<?php

namespace app\View;

use app\Util\TemplateRenderer;

class AccountView implements ViewInterface
{

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('accountpage.html',[
            '{{Username}}'=>$_SESSION['user']['username'],
            '{{Email}}'=>$_SESSION['user']['email'],
            '{{CreatedAt}}'=>$_SESSION['user']['createdAt']->format('Y-m-d H:i:s')
        ]);
    }
}