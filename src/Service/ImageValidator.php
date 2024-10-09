<?php

namespace app\Service;

use app\Util\StaticValidator;

class ImageValidator
{
    public function validateImage(string $imageType, int $imageSize): void
    {
        StaticValidator::assertIsImage($imageType);
        StaticValidator::assertIsProperSize($imageSize);
    }
}