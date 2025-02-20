<?php

namespace app\View;

use app\Util\TemplateRenderer;

interface ViewInterface
{
    public function renderWithRenderer(TemplateRenderer $renderer): string;
}