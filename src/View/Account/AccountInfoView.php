<?php

namespace app\View\Account;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\ViewInterface;

#[AllowDynamicProperties] class AccountInfoView implements ViewInterface
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml('account/accountinfo.html', $this->data);
    }
}