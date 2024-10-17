<?php

namespace app\View;

use AllowDynamicProperties;
use app\Util\TemplateRenderer;

#[AllowDynamicProperties] class SinglePostView implements ViewInterface
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function renderWithRenderer(TemplateRenderer $renderer): string
    {
        return $renderer->renderPost('post.html', $this->data);
    }
}