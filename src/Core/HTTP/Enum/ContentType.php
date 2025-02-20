<?php

namespace app\Core\HTTP\Enum;
enum ContentType: string
{
    case text = 'Content-Type: text/html';
    case image = 'Content-Type: image/jpeg';
    case application = 'Content-Type: application/json';
}
