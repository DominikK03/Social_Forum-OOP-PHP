<?php

namespace app\Util;


class TemplateRenderer
{
    public function renderImagesHtml(string $html, array $data) : string
    {
        $template = file_get_contents(TEMPLATE_PATH . '/' . $html);
        $imagesHtml = '';
        if (isset($data['{images}'])) {
            foreach ($data['{images}'] as $image) {
                $imagesHtml .='<div class="col-sm-6 col-md-4 col-lg-3 mb-3">
                               <img src="' . $image . '" alt="JustExampleModel" width="200" height="175">
                               </div>';
            }
            $template = str_replace('{images}', $imagesHtml, $template);


        }
        return $template;
    }

    public function renderHtml(string $html, array $data = []): string
    {
        $template = file_get_contents(TEMPLATE_PATH . '/' . $html);

        foreach ($data as $key => $value) {
            $template = str_replace($key, $value, $template);
        }

        return $template;
    }
}
