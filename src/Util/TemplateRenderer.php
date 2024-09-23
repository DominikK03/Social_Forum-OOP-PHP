<?php

namespace app\Util;


class TemplateRenderer
{
    public function renderHtml(string $html, array $data = []): string
    {
        $template = file_get_contents(TEMPLATE_PATH . '/' . $html);

        foreach ($data as $key => $value) {
            $template = str_replace($key, $value, $template);
        }

        return $template;
    }
}
