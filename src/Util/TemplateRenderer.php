<?php

namespace app\Util;
use AllowDynamicProperties;
use app\Exception\FileNotFoundException;

#[AllowDynamicProperties]
class TemplateRenderer
{
    /**
     * @throws FileNotFoundException
     */
    public function renderHtml(string $html, array $data = []): string
    {
        $template = FileSystem::readFile(TEMPLATE_PATH . '/' . $html);
        if ($data) {
            foreach ($data as $key => $value) {
                $template = str_replace(sprintf("{{%s}}", $key), $value, $template);
            }
        }
        return $template;
    }
}

