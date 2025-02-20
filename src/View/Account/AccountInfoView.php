<?php

namespace app\View\Account;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;
use app\View\ViewInterface;

#[AllowDynamicProperties] class AccountInfoView implements ViewInterface
{
    const ACCOUNT_INFO_VIEW = 'account/accountinfo.html';
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderHtml(self::ACCOUNT_INFO_VIEW, $this->data);
    }
}